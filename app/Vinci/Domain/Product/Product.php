<?php

namespace Vinci\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Channel\Contracts\Channel as ChannelInterface;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Pricing\Calculator\PriceCalculator;
use Vinci\Domain\Producer\Producer;
use Vinci\Domain\Product\ProductType as ProductArchType;
use Vinci\Domain\ProductType\ProductType;
use Vinci\Domain\Region\Region;
use Vinci\Domain\Template\Template;

/**
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "product" = "Vinci\Domain\Product\Product",
 *     "wine" = "Vinci\Domain\Product\Wine\Wine",
 *     "kit" = "Vinci\Domain\Product\Kit\Kit"
 * })
 * @ORM\EntityListeners({"Vinci\Domain\Product\Events\Listeners\ProductListener"})
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Product extends Model implements ProductInterface, Presentable
{

    use Timestamps, SoftDeletes, Schedulable, PresentableTrait;

    protected $presenter = 'Vinci\App\Website\Http\Product\Presenter\ProductPresenter';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status = Status::DRAFT;

    /**
     * @ORM\Column(type="boolean", options={"default" = 0})
     */
    protected $online = false;

    /**
     * @ORM\Column(type="boolean", options={"default" = 0})
     */
    protected $enabledForPromotions = false;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\ProductVariant", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "asc"})
     */
    protected $variants;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\AttributeValue", mappedBy="product", cascade={"persist", "remove"}, indexBy="id", orphanRemoval=true)
     */
    protected $attributes;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Product\Option")
     * @ORM\JoinTable(name="products_options",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="option_id", referencedColumnName="id")}
     *     )
     */
    protected $options;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Channel\Channel", inversedBy="products", indexBy="id")
     * @ORM\JoinTable(name="products_channels")
     */
    protected $channels;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\ProductType")
     */
    protected $archType;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Country\Country", inversedBy="products")
     */
    protected $country;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Region\Region", inversedBy="products")
     */
    protected $region;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\ProductType\ProductType", inversedBy="products")
     */
    protected $productType;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Producer\Producer", inversedBy="products")
     */
    protected $producer;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Customer\Customer", mappedBy="favoriteProducts")
     */
    protected $customers;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Template\Template")
     */
    protected $template;

    protected $currentChannel;

    protected $priceCalculator;

    protected $priceConfigurationResolver;

    public function __construct()
    {
        $this->variants = new ArrayCollection;
        $this->attributes = new ArrayCollection;
        $this->options = new ArrayCollection;
        $this->channels = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getVariants()
    {
        return $this->variants;
    }

    public function setVariants(Collection $variants)
    {
        $this->variants->clear();

        foreach ($variants as $variant) {
            $this->addVariant($variant);
        }
    }

    public function addVariant(ProductVariant $variant)
    {
        if (! $this->hasVariant($variant)) {
            $variant->setProduct($this);
            $this->variants->add($variant);
        }
    }

    public function removeVariant(ProductVariant $variant)
    {
        if ($this->hasVariant($variant)) {
            $variant->setProduct(null);
            $this->variants->removeElement($variant);
        }
    }

    public function hasVariant(ProductVariant $variant)
    {
        return $this->variants->contains($variant);
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttributesSorted()
    {
        $attributes = $this->attributes->toArray();

        usort($attributes, function($a1, $a2) {
            return $a1->getAttribute()->getCreatedAt() > $a2->getAttribute()->getCreatedAt();
        });

        return new ArrayCollection($attributes);
    }

    public function setAttributes(Collection $attributes)
    {
        $this->attributes->clear();

        foreach ($attributes as $attribute) {
            $this->addAttribute($attribute);
        }

        return $this;
    }

    public function hasAttributes()
    {
        return $this->attributes->count() > 0;
    }

    public function addAttribute(AttributeValue $attribute)
    {
        if (! $this->hasAttributeValue($attribute)) {
            $attribute->setProduct($this);

            if (!empty($attribute->getId())) {
                $this->attributes->set($attribute->getId(), $attribute);
            } else {
                $this->attributes->add($attribute);
            }
        }
    }

    public function removeAttribute(AttributeValue $attribute)
    {
        if ($this->hasAttributeValue($attribute)) {
            $this->attributes->removeElement($attribute);
        }
    }

    public function hasAttributeValue(AttributeValue $attribute)
    {
        return $this->attributes->containsKey($attribute->getId());
    }

    public function hasAttribute(Attribute $attribute)
    {
        foreach ($this->attributes as $attr) {
            if ($attribute == $attr->getAttribute()) {
                return true;
            }
        }

        return false;
    }

    public function getAttribute($code)
    {
        foreach ($this->attributes as $attribute) {
            if ($attribute->getCode() == $code) {
                return $attribute;
            }
        }
    }

    public function hasAttributeByName($name)
    {
        return (bool) $this->getAttribute($name);
    }

    public function getMasterVariant()
    {
        foreach ($this->variants as $variant) {
            if ($variant->isMaster()) {
                return $variant;
            }
        }
    }

    public function setMasterVariant(ProductVariant $masterVariant)
    {
        foreach ($this->variants as $variant) {
            $variant->setMaster(false);
        }

        $masterVariant->setMaster(true);

        if (! $this->hasVariant($masterVariant)) {
            $masterVariant->setProduct($this);
            $this->variants->add($masterVariant);
        }

        return $this;
    }

    public function getChannels()
    {
        return $this->channels;
    }

    public function setChannels(Collection $channels)
    {
        $this->channels->clear();

        foreach ($channels as $channel) {
            $this->addChannel($channel);
        }

        return $this;
    }

    public function addChannel(Channel $channel)
    {
        if (! $this->hasChannel($channel)) {
            $this->channels->set($channel->getId(), $channel);
        }

        return $this;
    }

    public function removeChannel(Channel $channel)
    {
        if ($this->hasChannel($channel)) {
            $this->channels->remove($channel->getId());
        }
    }

    public function hasChannel(Channel $channel)
    {
        return $this->channels->containsKey($channel->getId());
    }

    public function normalizeChannel($channel)
    {
        if ($channel instanceof ChannelInterface) {
            return $channel;
        }

        foreach ($this->channels as $ch) {
            if ($ch->getCode() == $channel) {
                return $ch;
            }
        }

        return $this->getDefaultChannel();
    }

    public function getCurrentChannel()
    {
        if (empty($this->currentChannel)) {
            return $this->currentChannel = $this->getDefaultChannel();
        }

        return $this->currentChannel instanceof ChannelInterface ?
            $this->currentChannel : $this->normalizeChannel($this->currentChannel);
    }

    public function setCurrentChannel($channel)
    {
        $ch = $this->normalizeChannel($channel);

        if (! $ch) {
            throw new \Exception(sprintf('The channel "%s" has not been set or does not exist.', $channel));
        }

        $this->currentChannel = $channel;
        return $this;
    }

    public function getDefaultChannel()
    {
        foreach ($this->channels as $channel) {
            if ($channel->isDefault()) {
                return $channel;
            }
        }
    }

    public function isOnline()
    {
        return $this->online;
    }

    public function setOnline($online)
    {
        $this->online = (bool) $online;
        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = (int) $status;
        return $this;
    }

    public function getTitle()
    {
        return $this->getMasterVariant()->getTitle();
    }

    public function setTitle($title)
    {
        $this->getMasterVariant()->setTitle($title);
        return $this;
    }

    public function getDescription()
    {
        return $this->getMasterVariant()->getDescription();
    }

    public function setDescription($description)
    {
        $this->getMasterVariant()->setDescription($description);
        return $this;
    }

    public function hasShortDescription()
    {
        return ! empty($this->getShortDescription());
    }

    public function getShortDescription()
    {
        return $this->getMasterVariant()->getShortDescription();
    }

    public function setShortDescription($description)
    {
        $this->getMasterVariant()->setShortDescription($description);
        return $this;
    }

    public function getSeoTitle()
    {
        return $this->getMasterVariant()->getSeoTitle();
    }

    public function setSeoTitle($title)
    {
        $this->getMasterVariant()->setSeoTitle($title);
        return $this;
    }

    public function getSeoDescription()
    {
        return $this->getMasterVariant()->getSeoDescription();
    }

    public function setSeoDescription($description)
    {
        $this->getMasterVariant()->setSeoDescription($description);
        return $this;
    }

    public function getSeoKeywords()
    {
        return $this->getMasterVariant()->getSeoKeywords();
    }

    public function setSeoKeywords($keywords)
    {
        $this->getMasterVariant()->setSeoKeywords($keywords);
        return $this;
    }

    public function getPrices()
    {
        return $this->getMasterVariant()->getPrices();
    }

    public function getPrice($channel = null)
    {
        return $this->getMasterVariant()->getPrice($channel);
    }

    public function getSalePrice($channel = null)
    {
        return $this->getMasterVariant()->getSalePrice($channel);
    }

    public function getOriginalSalePrice($channel = null)
    {
        return $this->getMasterVariant()->getOriginalSalePrice($channel);
    }

    public function addPrice(ProductVariantPrice $price)
    {
        $this->getMasterVariant()->addPrice($price);
        return $this;
    }

    public function shouldImportPrice()
    {
        return $this->getMasterVariant()->shouldImportPrice();
    }

    public function setImportPrice($importPrice)
    {
        $this->getMasterVariant()->setImportPrice($importPrice);
        return $this;
    }

    public function shouldImportStock()
    {
        return $this->getMasterVariant()->shouldImportStock();
    }

    public function setImportStock($importStock)
    {
        $this->getMasterVariant()->setImportStock($importStock);
        return $this;
    }

    public function getSlug()
    {
        return $this->getMasterVariant()->getSlug();
    }

    public function setSlug($slug)
    {
        $this->getMasterVariant()->setSlug($slug);
        return $this;
    }

    public function getSku()
    {
        return $this->getMasterVariant()->getSku();
    }

    public function setSku($sku)
    {
        $this->getMasterVariant()->setSku($sku);
        return $this;
    }

    public function getStock()
    {
        return $this->getMasterVariant()->getStock();
    }

    public function setStock($stock)
    {
        $this->getMasterVariant()->setStock($stock);
        return $this;
    }

    public function setPriceCalculator(PriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
        return $this;
    }

    public function getPriceCalculator()
    {
        return $this->priceCalculator;
    }

    public function getArchType()
    {
        return $this->archType;
    }

    public function setArchType(ProductArchType $archType)
    {
        $this->archType = $archType;
        return $this;
    }

    public function isType($type)
    {
        return $this->getArchType()->is($type);
    }

    public function isWine()
    {
        return $this->isType(ProductArchType::TYPE_WINE);
    }

    public function syncChannels(ArrayCollection $channels)
    {
        $toRemove = $this->channels->filter(function($channel) use ($channels) {
            if ($channels->containsKey($channel->getId())) {
                return false;
            }
            return true;
        });

        foreach ($toRemove as $channel) {
            $this->channels->remove($channel->getId());
        }

        foreach ($channels as $channel) {
            $this->addChannel($channel);
        }

        return $this;
    }

    public function syncAttributes(ArrayCollection $attributes)
    {
        $toRemove = $this->attributes->filter(function($attribute) use ($attributes) {
            if ($attributes->containsKey($attribute->getId())) {
                return false;
            }
            return true;
        });

        foreach ($toRemove as $attribute) {
            $this->attributes->remove($attribute->getId());
        }

        foreach ($attributes as $attr) {

            $attr->setProduct($this);

            if ($this->attributes->containsKey($attr->getId())) {
                $attribute = $this->attributes->get($attr->getId());
                $attribute->setValue($attr->getValue());

            } else {
                $this->attributes->add($attr);
            }
        }

        return $this;
    }

    public function syncPrices(ArrayCollection $prices)
    {
        $this->getMasterVariant()->syncPrices($prices);
        return $this;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry(Country $country)
    {
        $this->country = $country;
        return $this;
    }

    public function hasCountry()
    {
        return $this->country !== null;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function setRegion(Region $region)
    {
        $this->region = $region;
        return $this;
    }

    public function hasRegion()
    {
        return $this->region !== null;
    }

    public function getProducer()
    {
        return $this->producer;
    }

    public function setProducer(Producer $producer)
    {
        $this->producer = $producer;
        return $this;
    }

    public function hasProducer()
    {
        return $this->producer !== null;
    }

    public function getImages()
    {
        return $this->getMasterVariant()->getImages();
    }

    public function setImages(ArrayCollection $images)
    {
        $this->getMasterVariant()->setImages($images);
        return $this;
    }

    public function getImagesUploadPath()
    {
        return $this->getMasterVariant()->getImagesUploadPath();
    }

    public function addImage(Image $image, $version)
    {
        $this->getMasterVariant()->addImage($image, $version);
        return $this;
    }

    public function removeImage(Image $image)
    {
        $this->getMasterVariant()->removeImage($image);
        return $this;
    }

    public function getImage($version)
    {
        return $this->getMasterVariant()->getImage($version);
    }

    public function hasImage($version)
    {
        return $this->getMasterVariant()->hasImage($version);
    }

    public function isInClearanceSale()
    {
        return false;
    }

    public function getProductType()
    {
        return $this->productType;
    }

    public function setProductType(ProductType $productType)
    {
        $this->productType = $productType;
        return $this;
    }

    public function hasProductType()
    {
        return $this->productType !== null;
    }

    public function hasDescription()
    {
        return ! empty($this->getDescription());
    }

    public function getWebPath()
    {
        return with(app('product.url_generator'))->generate($this);
    }

    public function getType()
    {
        return self::TYPE_PRODUCT;
    }

    public function canBePromoted()
    {
        return (bool) $this->enabledForPromotions;
    }

    public function setEnabledForPromotions($value = null)
    {
        $this->enabledForPromotions = (bool) $value;
        return $this;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate(Template $template)
    {
        $this->template = $template;
        return $this;
    }

    public function hasTemplate()
    {
        return ! empty($this->template);
    }

    public function hasStock()
    {
        return $this->getMasterVariant()->hasStock();
    }

    public function isAvailable()
    {
        return $this->hasStock() && $this->getSalePrice() > 0;
    }

    public function getPackSize()
    {
        return $this->getMasterVariant()->getPackSize();
    }

    public function setPackSize($packSize)
    {
        $this->getMasterVariant()->setPackSize($packSize);
        return $this;
    }

    public function getDimension()
    {
        return $this->getMasterVariant()->getDimension();
    }

    public function setDimension(Dimension $dimension)
    {
        $this->getMasterVariant()->getDimension($dimension);
        return $this;
    }
    
    public function isGiftPackage()
    {
        return $this->getProductType()->getId() == ProductType::TYPE_PACKING;
    }

    public function getShippingMetrics()
    {
        return $this->getMasterVariant()->getShippingMetrics();
    }

    public function setShippingMetrics(ShippingMetrics $shippingMetrics)
    {
        $this->getMasterVariant()->setShippingMetrics($shippingMetrics);
        return $this;
    }

}
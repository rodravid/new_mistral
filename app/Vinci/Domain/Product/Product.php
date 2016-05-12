<?php

namespace Vinci\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Channel\Contracts\Channel as ChannelInterface;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Pricing\Calculator\PriceCalculator;

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
 */
class Product extends Model implements ProductInterface
{

    use Timestamps, SoftDeletes, Schedulable;

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
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\ProductVariant", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $variants;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\AttributeValue", mappedBy="product", cascade={"persist", "remove"}, orphanRemoval=true)
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
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Channel\Channel", inversedBy="products", indexBy="channel_id")
     * @ORM\JoinTable(name="products_channels")
     */
    protected $channels;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\ProductType")
     */
    protected $archType;

    protected $currentChannel;

    protected $priceCalculator;

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

    public function setAttributes(Collection $attributes)
    {
        $this->attributes->clear();

        foreach ($attributes as $attribute) {
            $this->addAttribute($attribute);
        }

        return $this;
    }

    public function addAttribute(AttributeValue $attribute)
    {
        if (! $this->hasAttribute($attribute)) {
            $attribute->setProduct($this);
            $this->attributes->add($attribute);
        }
    }

    public function removeAttribute(AttributeValue $attribute)
    {
        if ($this->hasAttribute($attribute)) {
            $this->attributes->removeElement($attribute);
        }
    }

    public function hasAttribute(AttributeValue $attribute)
    {
        return $this->attributes->contains($attribute);
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
            $channel->addProduct($this);
            $this->channels->add($channel);
        }

        return $this;
    }

    public function removeChannel(Channel $channel)
    {
        if ($this->hasChannel($channel)) {
            $this->channels->removeElement($channel);
        }
    }

    public function hasChannel(Channel $channel)
    {
        return $this->channels->contains($channel);
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

    public function addPrice(ProductVariantPrice $price)
    {
        $this->getMasterVariant()->addPrice($price);
        return $this;
    }

    public function shouldImportPrice()
    {
        return $this->getMasterVariant()->shouldImportPrice();
    }

    public function shouldImportStock()
    {
        return $this->getMasterVariant()->shouldImportStock();
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

    public function setArchType(ProductType $archType)
    {
        $this->archType = $archType;
        return $this;
    }

    public function isType($type)
    {
        return $this->getArchType()->is($type);
    }

    public function syncChannels(ArrayCollection $channels)
    {
        $toRemove = $this->channels->filter(function($channel) use ($channels) {
            if ($channels->contains($channel)) {
                return false;
            }
            return true;
        });

        foreach ($toRemove as $channel) {
            $this->channels->remove($channel->getId());
        }

        foreach ($channels as $channel) {

            if ($this->channels->containsKey($channel->getId())) {
                $this->channels->set($channel->getId(), $channel);
            } else {
                $this->channels->add($channel);
            }
        }

        return $this;
    }

}
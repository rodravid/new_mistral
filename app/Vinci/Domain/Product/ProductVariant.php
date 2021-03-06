<?php

namespace Vinci\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Common\Event\HasEvents;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Common\Traits\SEOable;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Inventory\Events\StockWasChanged;
use Vinci\Domain\Inventory\Events\StockWasIncreased;
use Vinci\Domain\Inventory\Events\StockWasReduced;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_variants")
 */
class ProductVariant extends Model implements ProductVariantInterface, Presentable
{

    use Timestampable, SoftDeletes, SEOable, Schedulable, HasEvents, PresentableTrait;

    protected $presenter = ProductPresenter::class;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    protected $sku;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="short_description", type="text", nullable=true)
     */
    protected $shortDescription;

    /**
     * @ORM\Column(type="integer")
     */
    protected $stock;

    /**
     * @Gedmo\Slug(fields={"title", "sku"}, unique=true, updatable=false)
     * @ORM\Column(length=255, nullable=true)
     */
    protected $slug;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status = Status::DRAFT;

    /**
     * @ORM\Column(type="boolean", options={"default" = 0})
     */
    protected $master = false;

    /**
     * @ORM\Column(name="import_price", type="boolean", options={"default" = 1})
     */
    protected $importPrice = true;

    /**
     * @ORM\Column(name="import_stock", type="boolean", options={"default" = 1})
     */
    protected $importStock = true;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\ProductVariantImage", mappedBy="productVariant", cascade={"persist", "remove"}, indexBy="imageVersion", orphanRemoval=true)
     */
    protected $images;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product", inversedBy="variants")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $product;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Product\OptionValue")
     * @ORM\JoinTable(name="products_variants_options_values",
     *     joinColumns={@ORM\JoinColumn(name="variant_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="option_value_id", referencedColumnName="id")}
     *     )
     */
    protected $options;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\ProductVariantPrice", mappedBy="variant", cascade={"persist", "remove"}, indexBy="id", orphanRemoval=true)
     */
    protected $prices;

    /**
     * @ORM\Embedded(class="Vinci\Domain\Product\Dimension", columnPrefix = false)
     */
    protected $dimension;

    /**
     * @ORM\Embedded(class="Vinci\Domain\Product\ShippingMetrics", columnPrefix = false)
     */
    protected $shippingMetrics;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $packSize;

    /**
     * @ORM\Column(type="integer", name="search_relevance", options={"default" = 0}, nullable=true)
     */
    protected $searchRelevance = 0;

    /**
     * @ORM\Version
     * @ORM\Column(type="integer", options={"default" = 0})
     */
    protected $version;

    public function __construct()
    {
        $this->options = new ArrayCollection;
        $this->images = new ArrayCollection;
        $this->prices = new ArrayCollection;
        $this->dimension = new Dimension;
        $this->shippingMetrics = new ShippingMetrics;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function setStock($stock)
    {
        $this->stock = (int) $stock;
        return $this;
    }

    public function changeStock($stock)
    {
        $oldStock = $this->getStock();

        if ($stock != $oldStock) {
            $this->setStock($stock);
            $this->raise(new StockWasChanged($this, $oldStock));
        }
    }

    public function hasStock()
    {
        return $this->stock > 0;
    }

    public function increaseStock($quantity = 1)
    {
        $newStock = $this->getStock() + intval($quantity);

        $this->setStock($newStock);
        
        $this->raise(new StockWasIncreased($this, $newStock));
    }

    public function reduceStock($quantity = 1)
    {
        $newStock = $this->getStock() + intval($quantity);

        $this->setStock($newStock);

        $this->raise(new StockWasReduced($this, $newStock));
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function setSlug($slug)
    {
        $this->slug = ! empty($slug) ? $slug : null;
        return $this;
    }

    public function isMaster()
    {
        return $this->master;
    }

    public function setMaster($master)
    {
        $this->master = (bool) $master;
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

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product = null)
    {
        $this->product = $product;
        return $this;
    }

    public function getSku()
    {
        return $this->sku;
    }

    public function setSku($sku)
    {
        $this->sku = $sku;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(Collection $options)
    {
        $this->options = $options;
        return $this;
    }

    public function addOption(OptionValue $option)
    {
        if (! $this->hasOption($option)) {
            $this->options->add($option);
        }
    }

    public function removeOption(OptionValue $option)
    {
        if ($this->hasOption($option)) {
            $this->options->removeElement($option);
        }
    }

    public function hasOption(OptionValue $option)
    {
        return $this->options->contains($option);
    }

    public function getPrices()
    {
        return $this->prices;
    }

    public function setPrices(Collection $prices)
    {
        $this->prices = $prices;
        return $this;
    }

    public function addPrice(ProductVariantPrice $price)
    {
        if (! $this->hasPrice($price)) {
            $price->setVariant($this);
            $this->prices->set($price->getId(), $price);

        } else {
            $this->prices->get($price->getId())->override($price);
        }
    }

    public function removePrice(ProductVariantPrice $price)
    {
        if ($this->hasPrice($price)) {
            $this->prices->removeElement($price);
        }
    }

    public function hasPrice(ProductVariantPrice $price)
    {
        return $this->prices->containsKey($price->getId());
    }

    public function getDefaultChannel()
    {
        return $this->getProduct()->getDefaultChannel();
    }

    public function getCurrentChannel()
    {
        return $this->getProduct()->getCurrentChannel();
    }

    public function getChannels()
    {
        return $this->getProduct()->getChannels();
    }

    public function getImages()
    {
        return $this->images;
    }

    public function setImages(Collection $images)
    {
        $this->images = $images;
        return $this;
    }

    public function getImagesUploadPath()
    {
        return 'products/variants/' . $this->getId() . '/images';
    }

    public function addImage(Image $image, $version)
    {
        $variantImage = new ProductVariantImage;
        $variantImage->setImage($image);
        $variantImage->setProductVariant($this);
        $variantImage->setImageVersion($version);
        $this->images->remove($version);
        $this->images->set($version, $variantImage);
    }

    public function removeImage(Image $image)
    {
        foreach ($this->images as $img) {
            if ($image == $img->getImage()) {
                $this->images->removeElement($img);
            }
        }
    }

    public function getImage($version)
    {
        foreach ($this->images as $relation) {
            if ($relation->getImageVersion() == $version) {
                return $relation->getImage();
            }
        }
    }

    public function hasImage($version)
    {
        return !! $this->getImage($version);
    }

    public function getSalePrice($channel = null)
    {
        return $this->getPrice($channel)->asSalePrice();
    }

    public function getOriginalSalePrice($channel = null)
    {
        $price =  $this->getPrice($channel);
        $salePrice = $price->asSalePrice();
        $originalSalePrice = $price->asOriginalSalePrice();

        if ($originalSalePrice > $salePrice) {
            return $originalSalePrice;
        }
    }

    public function getPrice($channel = null)
    {
        if (! $price = $this->getPriceOnChannel($channel)) {
            return $this->getPriceOnChannel($this->getDefaultChannel());
        }

        return $price;
    }

    protected function getPriceOnChannel($channel)
    {
        if ($channel instanceof Channel) {
            $channelCode = $channel->getCode();

        } else {
            $channelCode = empty($channel) ? $this->getCurrentChannel()->getCode() : $channel;
        }

        foreach ($this->prices as $price) {
            if ($price->getChannel()->getCode() == $channelCode) {
                return $price;
            }
        }
    }

    public function getPriceCalculator()
    {
        return $this->getProduct()->getPriceCalculator();
    }

    public function getShortDescription()
    {
        return $this->shortDescription;
    }

    public function setShortDescription($shortDescription)
    {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    public function shouldImportPrice()
    {
        return $this->importPrice;
    }

    public function setImportPrice($importPrice)
    {
        $this->importPrice = (bool) $importPrice;
        return $this;
    }

    public function shouldImportStock()
    {
        return $this->importStock;
    }

    public function setImportStock($importStock)
    {
        $this->importStock = (bool) $importStock;
        return $this;
    }

    public function syncPrices(ArrayCollection $prices)
    {
        $toRemove = $this->prices->filter(function($price) use ($prices) {
            if ($prices->containsKey($price->getId())) {
                return false;
            }
            return true;
        });

        foreach ($toRemove as $price) {
            $this->prices->removeElement($price);
        }

        foreach ($prices as $price) {
            $this->addPrice($price);
        }

        return $this;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function hasProducer()
    {
        return $this->product->hasProducer();
    }

    public function getProducer()
    {
        return $this->product->getProducer();
    }

    public function getDimension()
    {
        return $this->dimension;
    }

    public function setDimension(Dimension $dimension)
    {
        $this->dimension = $dimension;
        return $this;
    }

    public function getShippingMetrics()
    {
        return $this->shippingMetrics;
    }

    public function setShippingMetrics(ShippingMetrics $shippingMetrics)
    {
        $this->shippingMetrics = $shippingMetrics;
        return $this;
    }

    public function getPackSize()
    {
        return $this->packSize;
    }

    public function setPackSize($packSize)
    {
        $this->packSize = (int) $packSize;
        return $this;
    }

    public function getSearchRelevance()
    {
        return $this->searchRelevance;
    }

    public function setSearchRelevance($searchRelevance)
    {
        $this->searchRelevance = intval($searchRelevance);
        return $this;
    }
}
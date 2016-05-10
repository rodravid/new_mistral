<?php

namespace Vinci\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Common\Traits\SEOable;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Image\Image;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_variants")
 */
class ProductVariant extends Model implements ProductVariantInterface
{

    use Timestampable, SoftDeletes, SEOable, Schedulable;

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
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\ProductVariantImage", mappedBy="productVariant", cascade={"persist", "remove"}, indexBy="imageVersion", orphanRemoval=true)
     */
    protected $images;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product", inversedBy="variants")
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
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\ProductVariantPrice", mappedBy="variant")
     */
    protected $prices;

    public function __construct()
    {
        $this->options = new ArrayCollection;
        $this->images = new ArrayCollection;
        $this->prices = new ArrayCollection;
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

            if (! $price->hasChannel()) {
                $price->setChannel($this->getDefaultChannel());
            }

            $this->prices->add($price);
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
        return $this->prices->contains($price);
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
            $channelCode = $channel ?? $this->getCurrentChannel()->getCode();
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

    public function getSalePrice()
    {
        // TODO: Implement getSalePrice() method.
    }

    public function getOriginalPrice()
    {
        // TODO: Implement getOriginalPrice() method.
    }
}
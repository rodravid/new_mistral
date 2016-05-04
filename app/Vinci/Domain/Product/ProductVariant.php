<?php

namespace Vinci\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Common\Traits\SEOable;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_variants")
 */
class ProductVariant extends Model
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
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $price;

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

    public function __construct()
    {
        $this->options = new ArrayCollection;
        $this->images = new ArrayCollection;
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

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = (double) $price;
        return $this;
    }

    public function getOldPrice()
    {
        // TODO: Implement getOldPrice() method.
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

}
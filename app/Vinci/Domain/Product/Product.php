<?php

namespace Vinci\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Common\Status;
use Vinci\Domain\Common\Traits\Schedulable;
use Vinci\Domain\Core\Model;

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
class Product extends Model
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

    public function __construct()
    {
        $this->variants = new ArrayCollection;
        $this->attributes = new ArrayCollection;
        $this->options = new ArrayCollection;
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

    public function getPrice()
    {
        return $this->getMasterVariant()->getPrice();
    }

    public function setPrice($price)
    {
        $this->getMasterVariant()->setPrice($price);
        return $this;
    }

    public function getOldPrice()
    {
        // TODO: Implement getOldPrice() method.
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

}
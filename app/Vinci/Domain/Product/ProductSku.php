<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="products_skus")
 */
class ProductSku
{

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
     * @ORM\Column(type="decimal")
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
    protected $status;

    /**
     * @ORM\Column(type="boolean", options={"default" = 0})
     */
    protected $online = false;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Image\Image")
     * @ORM\JoinTable(name="products_photos",
     *     joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="photo_id", referencedColumnName="id", unique=true)}
     *     )
     */
    protected $photos;

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

    public function getPrice()
    {
        return $this->price;
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

}
<?php

namespace Vinci\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_types")
 */
class ProductType
{

    use Timestampable;

    const TYPE_PRODUCT = 'product';
    const TYPE_WINE = 'wine';
    const TYPE_KIT = 'kit';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $code;

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Product\Attribute")
     * @ORM\JoinTable(name="products_types_attributes",
     *     joinColumns={@ORM\JoinColumn(name="product_type_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="attribute_id", referencedColumnName="id")}
     *     )
     */
    protected $attributes;

    public function __construct()
    {
        $this->attributes = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
        return $this;
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
    }

    public function addAttribute(Attribute $attribute)
    {
        if (! $this->hasAttribute($attribute)) {
            $this->attributes->add($attribute);
        }
    }

    public function removeAttribute(Attribute $attribute)
    {
        if ($this->hasAttribute($attribute)) {
            $this->attributes->removeElement($attribute);
        }
    }

    public function hasAttribute(Attribute $attribute)
    {
        return $this->attributes->contains($attribute);
    }

    public function is($type)
    {
        return $this->getCode() == $type;
    }

}
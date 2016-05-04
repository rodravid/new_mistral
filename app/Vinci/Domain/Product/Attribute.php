<?php

namespace Vinci\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_attributes")
 */
class Attribute
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $code;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $type = 'text';

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\AttributeValue", mappedBy="attribute", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $values;

    /**
     * @ORM\Column(type="string")
     */
    protected $storageType;

    public function __construct()
    {
        $this->values = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setCode($code)
    {
        $this->code = $code;
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

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getStorageType()
    {
        return $this->storageType;
    }

    public function setStorageType($storageType)
    {
        $this->storageType = $storageType;
        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }

}

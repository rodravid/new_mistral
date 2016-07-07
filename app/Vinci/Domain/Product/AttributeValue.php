<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="products_attributes_values")
 */
class AttributeValue
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product", inversedBy="attributes")
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Attribute")
     */
    protected $attribute;

    /**
     * @ORM\Column(name="text_value", type="string", nullable=true)
     */
    protected $text;

    /**
     * @ORM\Column(name="boolean_value", type="boolean", nullable=true)
     */
    protected $boolean;

    /**
     * @ORM\Column(name="integer_value", type="integer", nullable=true)
     */
    protected $integer;

    /**
     * @ORM\Column(name="float_value", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $float;

    /**
     * @ORM\Column(name="datetime_value", type="datetime", nullable=true)
     */
    protected $datetime;

    /**
     * @ORM\Column(name="date_value", type="date", nullable=true)
     */
    protected $date;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
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

    public function getAttribute()
    {
        return $this->attribute;
    }

    public function getAttributeId()
    {
        $this->assertAttributeIsSet();

        return $this->getAttribute()->getId();
    }

    public function setAttribute(Attribute $attribute)
    {
        $this->attribute = $attribute;
        return $this;
    }

    public function getValue()
    {
        if (null === $this->attribute) {
            return null;
        }

        $getter = 'get'.ucfirst($this->attribute->getStorageType());

        $value = $this->$getter();

        if (empty($value)) {
            return '';
        }

        return $value;
    }

    public function setValue($value)
    {
        $this->assertAttributeIsSet();

        $property = $this->attribute->getStorageType();
        $this->$property = $value;
    }

    public function getCode()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getCode();
    }

    public function getName()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getName();
    }

    public function getType()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getType();
    }

    public function getBoolean()
    {
        return $this->boolean;
    }

    public function setBoolean($boolean)
    {
        $this->boolean = $boolean;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getInteger()
    {
        return $this->integer;
    }

    public function setInteger($integer)
    {
        $this->integer = $integer;
        return $this;
    }

    public function getFloat()
    {
        return $this->float;
    }

    public function setFloat($float)
    {
        $this->float = $float;
        return $this;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTime $datetime)
    {
        $this->datetime = $datetime;
        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    protected function assertAttributeIsSet()
    {
        if (null === $this->attribute) {
            throw new \BadMethodCallException('The attribute is undefined, so you cannot access proxy methods.');
        }
    }

}

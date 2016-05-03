<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;

class AttributeValue
{

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var AttributeProductInterface
     */
    protected $product;

    /**
     * @var AttributeInterface
     */
    protected $attribute;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var bool
     */
    protected $boolean;

    /**
     * @var int
     */
    protected $integer;

    /**
     * @var float
     */
    protected $float;

    /**
     * @var \DateTime
     */
    protected $datetime;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
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

        return $this->$getter();
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value)
    {
        $this->assertAttributeIsSet();

        $property = $this->attribute->getStorageType();
        $this->$property = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getName();
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        $this->assertAttributeIsSet();

        return $this->attribute->getType();
    }

    /**
     * @return bool
     */
    public function getBoolean()
    {
        return $this->boolean;
    }

    /**
     * @param bool $boolean
     */
    public function setBoolean($boolean)
    {
        $this->boolean = $boolean;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getInteger()
    {
        return $this->integer;
    }

    /**
     * @param int $integer
     */
    public function setInteger($integer)
    {
        $this->integer = $integer;
    }

    /**
     * @return float
     */
    public function getFloat()
    {
        return $this->float;
    }

    /**
     * @param float $float
     */
    public function setFloat($float)
    {
        $this->float = $float;
    }

    /**
     * @return \DateTime
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * @param \DateTime $datetime
     */
    public function setDatetime(\DateTime $datetime)
    {
        $this->datetime = $datetime;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
    /**
     * @throws \BadMethodCallException
     */
    protected function assertAttributeIsSet()
    {
        if (null === $this->attribute) {
            throw new \BadMethodCallException('The attribute is undefined, so you cannot access proxy methods.');
        }
    }

}

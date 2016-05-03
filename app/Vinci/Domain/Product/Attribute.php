<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;

class Attribute
{

    /**
     * @var mixed
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     *
     */
    protected $name;

    /**
     * @var string
     */
    protected $type = TextAttributeType::TYPE;

    /**
     * @var array
     */
    protected $configuration = [];

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\AttributeValue")
     */
    protected $values;

    /**
     * @var string
     */
    protected $storageType;

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->values = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
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

    public function getConfiguration()
    {
        return $this->configuration;
    }

    public function setConfiguration(array $configuration)
    {
        $this->configuration = $configuration;
    }

    public function getValues()
    {
        return $this->values;
    }

}

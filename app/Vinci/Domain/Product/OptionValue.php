<?php

namespace Vinci\Domain\Product;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="options_values")
 */
class OptionValue
{

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
    protected $value;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Option", inversedBy="values")
     */
    protected $option;

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
        return $this;
    }

    public function getOption()
    {
        return $this->option;
    }

    public function setOption(Option $option = null)
    {
        $this->option = $option;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function getOptionCode()
    {
        if (null === $this->option) {
            throw new \BadMethodCallException('The option have not been created yet so you cannot access proxy methods.');
        }

        return $this->option->getCode();
    }

    public function getPresentation()
    {
        if (null === $this->option) {
            throw new \BadMethodCallException('The option have not been created yet so you cannot access proxy methods.');
        }

        return $this->option->getName();
    }

    public function __toString()
    {
        return $this->getValue();
    }

}

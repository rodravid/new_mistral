<?php

namespace Vinci\Domain\Product;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="options")
 */
class Option
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
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\OptionValue", mappedBy="option", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $values;

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
        return $this;
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

    public function getValues()
    {
        return $this->values;
    }

    public function setValues(Collection $values)
    {
        $this->values = $values;
    }

    public function addValue(OptionValue $value)
    {
        if (! $this->hasValue($value)) {
            $value->setOption($this);
            $this->values->add($value);
        }
    }

    public function removeValue(OptionValue $value)
    {
        if ($this->hasValue($value)) {
            $this->values->removeElement($value);
            $value->setOption(null);
        }
    }

    public function hasValue(OptionValue $value)
    {
        return $this->values->contains($value);
    }

    public function __toString()
    {
        return $this->getName();
    }

}

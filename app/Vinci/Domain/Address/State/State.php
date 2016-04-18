<?php

namespace Vinci\Domain\Address\State;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Address\Country\Country;

/**
 * @ORM\Entity
 * @ORM\Table(name="ibge_states")
 */
class State
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=2, options={"fixed" = true})
     */
    protected $uf;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Address\Country\Country")
     */
    protected $country;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getUf()
    {
        return $this->uf;
    }

    public function setUf($uf)
    {
        $this->uf = $uf;
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

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry(Country $country)
    {
        $this->country = $country;
        return $this;
    }

}
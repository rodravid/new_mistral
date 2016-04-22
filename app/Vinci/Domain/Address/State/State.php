<?php

namespace Vinci\Domain\Address\State;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Address\City\City;
use Vinci\Domain\Address\Country\Country;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="ibge_states")
 */
class State extends Model
{

    use Timestamps;

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
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Address\Country\Country", inversedBy="states")
     */
    protected $country;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Address\City\City", mappedBy="state", cascade={"persist"})
     */
    protected $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection;
    }

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

    public function addCity(City $city)
    {
        if (! $this->cities->contains($city)) {
            $city->setState($this);
            $city->setUf($this->getUf());
            $this->cities->add($city);
        }

        return $this;
    }

}
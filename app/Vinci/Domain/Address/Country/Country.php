<?php

namespace Vinci\Domain\Address\Country;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Address\State\State;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="ibge_countries")
 */
class Country extends Model
{

    use Timestamps;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=2, options={"fixed" = true})
     */
    protected $initials;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Address\State\State", mappedBy="country", cascade={"persist"})
     */
    protected $states;

    public function __construct()
    {
        $this->states = new ArrayCollection;
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

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function getInitials()
    {
        return $this->initials;
    }

    public function setInitials($initials)
    {
        $this->initials = $initials;
        return $this;
    }

    public function addState(State $state)
    {
        if (! $this->states->contains($state)) {
            $state->setCountry($this);
            $this->states->add($state);
        }

        return $this;
    }

    public function getStates()
    {
        return $this->states;
    }

}
<?php

namespace Vinci\Domain\Product\Wine;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Product\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="wines")
 */
class Wine extends Product
{

    /**
     * @ORM\Column(name="bottle_size", type="string")
     */
    protected $bottleSize;

    /**
     * @ORM\Column(name="alcoholic_strength", type="string")
     */
    protected $alcoholicStrength;

    /**
     * @ORM\Column(name="temperature", type="string")
     */
    protected $temperature;

    /**
     * @ORM\Column(name="decantation", type="string")
     */
    protected $decantation;

    /**
     * @ORM\Column(name="vineyard", type="string")
     */
    protected $vineyard;

    /**
     * @ORM\Column(name="vinification", type="string")
     */
    protected $vinification;

    /**
     * @ORM\Column(name="maturation", type="string")
     */
    protected $maturation;

    /**
     * @ORM\Column(name="pairings", type="string")
     */
    protected $pairings;

    /**
     * @ORM\Column(name="fullbodied", type="string")
     */
    protected $fullbodied;

    /**
     * @ORM\Column(name="aging_potential", type="string")
     */
    protected $agingPotential;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Wine\GrapeContent", mappedBy="wine")
     */
    protected $grapeContent;

    public function getBottleSize()
    {
        return $this->bottleSize;
    }

    public function setBottleSize($bottleSize)
    {
        $this->bottleSize = $bottleSize;
        return $this;
    }

    public function getAlcoholicStrength()
    {
        return $this->alcoholicStrength;
    }

    public function setAlcoholicStrength($alcoholicStrength)
    {
        $this->alcoholicStrength = $alcoholicStrength;
        return $this;
    }

    public function getTemperature()
    {
        return $this->temperature;
    }

    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
        return $this;
    }

    public function getDecantation()
    {
        return $this->decantation;
    }

    public function setDecantation($decantation)
    {
        $this->decantation = $decantation;
        return $this;
    }

    public function getVineyard()
    {
        return $this->vineyard;
    }

    public function setVineyard($vineyard)
    {
        $this->vineyard = $vineyard;
        return $this;
    }

    public function getVinification()
    {
        return $this->vinification;
    }

    public function setVinification($vinification)
    {
        $this->vinification = $vinification;
        return $this;
    }

    public function getMaturation()
    {
        return $this->maturation;
    }

    public function setMaturation($maturation)
    {
        $this->maturation = $maturation;
        return $this;
    }

    public function getPairings()
    {
        return $this->pairings;
    }

    public function setPairings($pairings)
    {
        $this->pairings = $pairings;
        return $this;
    }

    public function getFullbodied()
    {
        return $this->fullbodied;
    }

    public function setFullbodied($fullbodied)
    {
        $this->fullbodied = $fullbodied;
        return $this;
    }

    public function getAgingPotential()
    {
        return $this->agingPotential;
    }

    public function setAgingPotential($agingPotential)
    {
        $this->agingPotential = $agingPotential;
        return $this;
    }

}
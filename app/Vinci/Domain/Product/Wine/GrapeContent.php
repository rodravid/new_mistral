<?php

namespace Vinci\Domain\Product\Wine;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="wines_grapes")
 */
class GrapeContent
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Wine\Wine", inversedBy="grapeContent")
     * @ORM\JoinColumn(name="wine_id", referencedColumnName="id", nullable=false)
     */
    protected $wine;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Grape\Grape")
     * @ORM\JoinColumn(name="grape_id", referencedColumnName="id", nullable=false)
     */
    protected $grape;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $weight;

    public function getWine()
    {
        return $this->wine;
    }

    public function setWine($wine)
    {
        $this->wine = $wine;
        return $this;
    }

    public function getGrape()
    {
        return $this->grape;
    }

    public function setGrape($grape)
    {
        $this->grape = $grape;
        return $this;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
        return $this;
    }

}
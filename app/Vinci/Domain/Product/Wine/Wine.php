<?php

namespace Vinci\Domain\Product\Wine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Product\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="wines")
 */
class Wine extends Product
{

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Wine\GrapeContent", mappedBy="wine")
     */
    protected $grapeContent;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Wine\Score", mappedBy="wine", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $scores;

    public function __construct()
    {
        parent::__construct();

        $this->grapeContent = new ArrayCollection;
        $this->scores = new ArrayCollection;
    }

    public function getGrapeContent()
    {
        return $this->grapeContent;
    }

    public function getScores()
    {
        return $this->getScores();
    }

    public function addScore(Score $score)
    {
        if (! $this->hasScore($score)) {
            $score->setWine($this);
            $this->scores->add($score);
        }

        return $this;
    }

    public function removeScore(Score $score)
    {
        if ($this->hasScore($score)) {
            $this->scores->removeElement($score);
        }

        return $this;
    }

    public function hasScore(Score $score)
    {
        return $this->scores->contains($score);
    }

}
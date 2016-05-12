<?php

namespace Vinci\Domain\Product\Wine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Grape\Grape;
use Vinci\Domain\Product\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="wines")
 */
class Wine extends Product
{

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Wine\GrapeContent", mappedBy="wine", cascade={"persist", "remove"}, orphanRemoval=true)
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
        return $this->scores;
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

    public function getGrapes()
    {
        return $this->grapeContent;
    }

    public function addGrape(Grape $grape, $weight)
    {
        $grapeContent = new GrapeContent();

        $grapeContent
            ->setWine($this)
            ->setGrape($grape)
            ->setWeight($weight);

        $this->addGrapeContent($grapeContent);

        return $this;
    }

    public function addGrapeContent(GrapeContent $grapeContent)
    {
        if (! $this->hasGrapeContent($grapeContent)) {
            $grapeContent->setWine($this);
            $this->grapeContent->add($grapeContent);
        }
    }

    public function hasGrapeContent(GrapeContent $grapeContent)
    {
        return $this->grapeContent->contains($grapeContent);
    }

    public function syncGrapeContent(ArrayCollection $grapesContents)
    {
        $toRemove = $this->grapeContent->filter(function($grapeContent) use ($grapesContents) {
            if ($grapesContents->contains($grapeContent)) {
                return false;
            }
            return true;
        });

        foreach ($toRemove as $grapeContent) {
            $this->grapeContent->removeElement($grapeContent);
        }

        foreach ($grapesContents as $grapeContent) {
            $this->addGrapeContent($grapeContent);
        }

        return $this;
    }

}
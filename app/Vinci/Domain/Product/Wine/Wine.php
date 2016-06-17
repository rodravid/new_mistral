<?php

namespace Vinci\Domain\Product\Wine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
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
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Wine\GrapeContent", mappedBy="wine", cascade={"all"}, indexBy="grape_id", orphanRemoval=true)
     */
    protected $grapeContent;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Wine\Score", mappedBy="wine")
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

    public function setGrapeContent(ArrayCollection $grapeContent)
    {
        foreach ($grapeContent as $item) {
            $item->setWine($this);

            if (! $this->grapeContent->containsKey($item->getGrape()->getId())) {
                $this->grapeContent->add($item);
            } else {
                $this->grapeContent->get($item->getGrape()->getId())->setWeight($item->getWeight());
            }

        }

        return $this;
    }

    public function getScores()
    {
        return $this->scores;
    }

    public function getHighlightedScores()
    {
        $expr = Criteria::expr();
        $criteria = Criteria::create();

        $criteria->where($expr->eq('highlight', true));

        return $this->scores->matching($criteria);
    }

    public function addScore(Score $score)
    {
        if (! $this->hasScore($score)) {
            $score->setWine($this);
            $this->scores->set($score->getId(), $score);

        } else {

            $this->scores->get($score->getId())->override($score);
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
        return $this->scores->containsKey($score->getId());
    }

    public function hasScores()
    {
        return (bool) $this->scores->count();
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
            $this->grapeContent->set($grapeContent->getId(), $grapeContent);

        } else {
            $this->grapeContent->get($grapeContent->getId())->setWeight($grapeContent->getWeight());
        }

        return $this;
    }

    public function hasGrapeContent(GrapeContent $grapeContent)
    {
        return $this->grapeContent->containsKey($grapeContent->getId());
    }

    public function syncGrapeContent(ArrayCollection $grapesContents)
    {
        $toRemove = $this->grapeContent->filter(function($grapeContent) use ($grapesContents) {
            if ($grapesContents->containsKey($grapeContent->getId())) {
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

    public function syncScores(ArrayCollection $scores)
    {
        $toRemove = $this->scores->filter(function($score) use ($scores) {
            if ($scores->containsKey($score->getId())) {
                return false;
            }
            return true;
        });

        foreach ($toRemove as $score) {
            $this->scores->removeElement($score);
        }

        foreach ($scores as $score) {
            $this->addScore($score);
        }

        return $this;
    }

    public function getType()
    {
        return self::TYPE_WINE;
    }

}
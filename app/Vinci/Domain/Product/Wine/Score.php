<?php

namespace Vinci\Domain\Product\Wine;

use Doctrine\ORM\Mapping as ORM;
use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\App\Website\Http\Product\Score\Presenter\ScorePresenter;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="wines_scores")
 */
class Score extends Model implements Presentable
{

    use Timestampable, PresentableTrait;

    protected $presenter = ScorePresenter::class;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Wine\Wine", inversedBy="scores")
     * @ORM\JoinColumn(name="wine_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $wine;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Wine\CriticalAcclaim", cascade={"persist"})
     * @ORM\JoinColumn(name="critical_acclaim_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $criticalAcclaim;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $year;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $value;

    /**
     * @ORM\Column(type="boolean", options={"default" = 0})
     */
    protected $highlight = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="integer", nullable=true, options={"default" = 0})
     */
    protected $position;

    public function getWine()
    {
        return $this->wine;
    }

    public function setWine(Wine $wine)
    {
        $this->wine = $wine;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = (int) $year;
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

    public function isHighlighted()
    {
        return $this->highlight;
    }

    public function setHighlight($highlight)
    {
        $this->highlight = (bool) $highlight;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function override(Score $score)
    {
        $this
            ->setYear($score->getYear())
            ->setValue($score->getValue())
            ->setHighlight($score->isHighlighted())
            ->setDescription($score->getDescription())
            ->setCriticalAcclaim($score->getCriticalAcclaim());

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = (int) $position;
        return $this;
    }

    public function getCriticalAcclaim()
    {
        return $this->criticalAcclaim;
    }

    public function setCriticalAcclaim(CriticalAcclaim $criticalAcclaim)
    {
        $this->criticalAcclaim = $criticalAcclaim;
        return $this;
    }

}
<?php

namespace Vinci\Domain\Product\Wine;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="wines_scores")
 */
class Score
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Wine\Wine", inversedBy="scores")
     */
    protected $wine;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="integer")
     */
    protected $year;

    /**
     * @ORM\Column(type="integer")
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

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
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

}
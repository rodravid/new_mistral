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

    public function getWine()
    {
        return $this->wine;
    }

    public function setWine(Wine $wine)
    {
        $this->wine = $wine;
        return $this;
    }

}
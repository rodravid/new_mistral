<?php

namespace Vinci\Domain\Product\Wine;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="wines_critical_acclaim")
 */
class CriticalAcclaim extends Model
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Wine\Score", mappedBy="criticalAcclaim", cascade={"persist", "remove"}, indexBy="id", orphanRemoval=true)
     */
    protected $scores;
    
    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

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
            ->setTitle($score->getTitle())
            ->setDescription($score->getDescription());

        return $this;
    }

}
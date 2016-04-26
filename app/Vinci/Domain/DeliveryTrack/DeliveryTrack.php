<?php

namespace Vinci\Domain\DeliveryTrack;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping AS ORM;
use Vinci\Domain\Common\Relationships\HasOneAdminUser;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity(repositoryClass="Vinci\Infrastructure\DeliveryTrack\DoctrineDeliveryTrackRepository")
 * @ORM\Table(name="delivery_tracks")
 */
class DeliveryTrack extends Model
{

    use Timestampable, HasOneAdminUser;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\Column(type="smallint", options={"default" = 0})
     */
    protected $status = 0;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\DeliveryTrack\Line",
     *     mappedBy="deliveryTrack",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true,
     *     fetch="EAGER")
     */
    protected $lines;

    public function __construct()
    {
        $this->lines = new ArrayCollection;
    }

    /**
     * @return mixed
     */
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

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getLines()
    {
        return $this->lines;
    }

    public function setLines(ArrayCollection $lines)
    {
        $this->lines = $lines;
        return $this;
    }

    public function addLine(Line $line)
    {
        if (! $this->lines->contains($line)) {
            $line->setDeliveryTrack($this);
            $this->lines->add($line);
        }

        return $this;
    }

}
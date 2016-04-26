<?php

namespace Vinci\Domain\DeliveryTrack;

use Doctrine\ORM\Mapping AS ORM;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="delivery_tracks_lines", indexes={@ORM\Index(name="track_idx", columns={"initial_track", "final_track"})})
 */
class Line extends Model
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(name="initial_track", type="string", length=10))
     */
    protected $initialTrack;

    /**
     * @ORM\Column(name="final_track", type="string", length=10)
     */
    protected $finalTrack;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\DeliveryTrack\DeliveryTrack", inversedBy="lines")
     */
    protected $deliveryTrack;

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = ! empty($description) ? $description : null;
        return $this;
    }

    public function getInitialTrack()
    {
        return $this->initialTrack;
    }

    public function setInitialTrack($initialTrack)
    {
        $this->initialTrack = only_numbers($initialTrack);
        return $this;
    }

    public function getFinalTrack()
    {
        return $this->finalTrack;
    }

    public function setFinalTrack($finalTrack)
    {
        $this->finalTrack = only_numbers($finalTrack);
        return $this;
    }

    public function getDeliveryTrack()
    {
        return $this->deliveryTrack;
    }

    public function setDeliveryTrack(DeliveryTrack $deliveryTrack)
    {
        $this->deliveryTrack = $deliveryTrack;
        return $this;
    }

}
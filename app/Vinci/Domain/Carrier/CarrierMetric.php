<?php

namespace Vinci\Domain\Carrier;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;

/**
 * @ORM\Entity
 * @ORM\Table(name="carriers_metrics")
 */
class CarrierMetric extends Model implements CarrierMetricInterface
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Carrier\Carrier", inversedBy="metrics")
     */
    protected $carrier;

    /**
     * @ORM\Column(name="initial_track", type="integer", nullable=true)
     */
    protected $initialTrack = 0;

    /**
     * @ORM\Column(name="final_track", type="integer", nullable=true)
     */
    protected $finalTrack;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $initialWeight = 0;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $finalWeight;

    /**
     * @ORM\Column(name="deadline", type="integer")
     */
    protected $deadline;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $price;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Carrier\Tax", mappedBy="carrierMetric", cascade={"persist"})
     */
    protected $taxes;

    public function __construct()
    {
        $this->taxes = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public function setCarrier(Carrier $carrier)
    {
        $this->carrier = $carrier;
        return $this;
    }

    public function getInitialTrack()
    {
        return $this->initialTrack;
    }

    public function setInitialTrack($initialTrack)
    {
        $this->initialTrack = (int) $initialTrack;
        return $this;
    }

    public function getFinalTrack()
    {
        return $this->finalTrack;
    }

    public function setFinalTrack($finalTrack)
    {
        $this->finalTrack = (int) $finalTrack;
        return $this;
    }

    public function getInitialWeight()
    {
        return $this->initialWeight;
    }

    public function setInitialWeight($initialWeight)
    {
        $this->initialWeight = (double) $initialWeight;
        return $this;
    }

    public function getFinalWeight()
    {
        return $this->finalWeight;
    }

    public function setFinalWeight($finalWeight)
    {
        $this->finalWeight = (double) $finalWeight;
        return $this;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function setDeadline($deadline)
    {
        $this->deadline = (int) $deadline;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = (double) $price;
        return $this;
    }

    public function getTaxes()
    {
        return $this->taxes;
    }

    public function addTax(TaxInterface $tax)
    {
        if (! $this->hasTax($tax)) {
            $tax->setCarrierMetric($this);
            $this->taxes->add($tax);
        }
    }

    public function hasTax(TaxInterface $tax)
    {
        return $this->taxes->contains($tax);
    }

    public function hasTaxes()
    {
        return $this->taxes->count() > 0;
    }
}
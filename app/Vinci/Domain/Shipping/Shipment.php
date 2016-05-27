<?php

namespace Vinci\Domain\Shipping;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_shipments")
 */
class Shipment implements ShipmentInterface
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Order\Order")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Carrier\Carrier")
     */
    protected $carrier;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $amount;

    /**
     * @ORM\Column(type="integer")
     */
    protected $deadline;

    
    protected $metrics;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getCarrier()
    {
        return $this->carrier;
    }

    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
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

}
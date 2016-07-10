<?php

namespace Vinci\Domain\Shipping;

use Doctrine\ORM\Mapping as ORM;
use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\Shipping\Presenter\ShipmentPresenter;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_shipments")
 */
class Shipment extends Model implements ShipmentInterface, Presentable
{

    use Timestampable, PresentableTrait;

    protected $presenter = ShipmentPresenter::class;

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

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
        return $this;
    }

}
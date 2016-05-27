<?php

namespace Vinci\Domain\Order\Address;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Address\Address as BaseAddress;
use Vinci\Domain\Order\OrderInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_addresses")
 */
class Address extends BaseAddress
{

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Order\Order")
     */
    protected $order;

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
<?php

namespace Vinci\Domain\Customers;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customers")
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string")
     */
    protected $lastname;

    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="customer", cascade={"persist"}, fetch="EAGER")
     * @var ArrayCollection|Order[]
     */
    protected $orders;

    /**
     * @param $firstname
     * @param $lastname
     */
    public function __construct($firstname, $lastname)
    {
        $this->firstname = $firstname;
        $this->lastname  = $lastname;

        $this->orders = new ArrayCollection;
    }

    public function addOrder(Order $order)
    {
        if (! $this->orders->contains($order)) {
            $order->setCustomer($this);
            $this->orders->add($order);
        }
    }

    public function getOrders()
    {
        return $this->orders;
    }

}
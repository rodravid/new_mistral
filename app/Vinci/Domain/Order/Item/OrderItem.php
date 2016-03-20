<?php

namespace Vinci\Domain\Order\Item;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders_items")
 */
class OrderItem
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
    protected $name;

    /**
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Order\Order", inversedBy="items")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product", fetch="EAGER")
     */
    protected $product;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getProduct()
    {
        return $this->product;
    }

}
<?php

namespace Vinci\Domain\Order;

use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use LaravelDoctrine\Extensions\Timestamps\Timestamps;
use Vinci\Domain\Core\Model;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Order extends Model
{

    use Timestamps, SoftDeletes;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $total;

    /**
     * @ORM\Column(type="integer")
     */
    protected $status;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Customer\Customer", inversedBy="orders")
     */
    protected $customer;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Order\Item\OrderItem", mappedBy="order", fetch="EAGER")
     */
    protected $items;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->items = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getItems()
    {
        return $this->items;
    }

}
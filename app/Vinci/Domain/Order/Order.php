<?php

namespace Vinci\Domain\Order;

use Doctrine\Common\Collections\ArrayCollection;
use LaravelDoctrine\Extensions\SoftDeletes\SoftDeletes;
use Vinci\Domain\Channel\Contracts\Channel;
use Vinci\Domain\Common\AggregateRoot;
use Vinci\Domain\Common\Event\HasEvents;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Order\Address\Address;
use Vinci\Domain\Order\Events\NewOrderWasCreated;
use Vinci\Domain\Order\Item\OrderItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
class Order extends Model implements OrderInterface, AggregateRoot
{

    use Timestampable, SoftDeletes, HasEvents;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Customer\Customer", inversedBy="orders")
     */
    protected $customer;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Channel\Channel")
     */
    protected $channel;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $total;

    /**
     * @ORM\Column(name="items_total", type="decimal", precision=13, scale=2)
     */
    protected $itemsTotal;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Order\Address\Address", cascade={"persist"})
     */
    protected $shippingAddress;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Order\Address\Address", cascade={"persist"})
     */
    protected $billingAddress;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Payment\Payment", mappedBy="order", cascade={"persist"})
     */
    protected $payments;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Order\Item\OrderItem", mappedBy="order", cascade={"persist"})
     */
    protected $items;

    /**
     * @ORM\Column(type="string")
     */
    protected $status = OrderInterface::STATUS_NEW;

    public function __construct()
    {
        $this->payments = new ArrayCollection;
        $this->items = new ArrayCollection;

        $this->raise(new NewOrderWasCreated($this));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    public function getChannel()
    {
        return $this->channel;
    }

    public function setChannel(Channel $channel)
    {
        $this->channel = $channel;
        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = (double) $total;
        return $this;
    }

    public function getItemsTotal()
    {
        return $this->itemsTotal;
    }

    public function setItemsTotal($itemsTotal)
    {
        $this->itemsTotal = (double) $itemsTotal;
        return $this;
    }

    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    public function setShippingAddress(Address $shippingAddress)
    {
        $shippingAddress->setOrder($this);
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    public function setBillingAddress(Address $billingAddress)
    {
        $billingAddress->setOrder($this);
        $this->billingAddress = $billingAddress;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function addItem(OrderItem $item)
    {
        if (! $this->hasItem($item)) {

            $item->setOrder($this);

            $this->items->add($item);

            $this->calculateItemsTotal();
            $this->calculateTotal();
        }
    }

    public function hasItem(OrderItem $item)
    {
        return $this->items->contains($item);
    }

    protected function calculateItemsTotal()
    {
        $this->itemsTotal = 0;
        foreach ($this->getItems() as $item) {
            $this->itemsTotal += $item->getTotal();
        }
    }

    protected function calculateTotal()
    {
        $this->total = $this->itemsTotal;
    }

    public function releaseEvents()
    {
        $events = $this->pendingEvents;
        $this->pendingEvents = [];

        foreach ($this->items as $item) {
            $events = array_merge($events, $item->releaseEvents());
        }

        return $events;
    }

}
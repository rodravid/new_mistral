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
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Order\Address\Address;
use Vinci\Domain\Order\Events\NewOrderWasCreated;
use Vinci\Domain\Order\Events\OrderStatusWasChanged;
use Vinci\Domain\Order\Events\OrderTrackingStatusWasChanged;
use Vinci\Domain\Order\Events\PaymentStatusWasChanged;
use Vinci\Domain\Order\History\OrderHistory;
use Vinci\Domain\Order\Item\OrderItem;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatus;
use Vinci\Domain\Payment\PaymentInterface;
use Vinci\Domain\Shipping\ShipmentInterface;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 * @ORM\HasLifecycleCallbacks
 */
class Order extends Model implements OrderInterface, AggregateRoot
{

    use Timestampable, SoftDeletes, HasEvents;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=11, options={"fixed" = true}, unique=true)
     */
    protected $number;

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
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Shipping\Shipment", cascade={"persist"})
     */
    protected $shipment;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Order\Item\OrderItem", mappedBy="order", cascade={"persist"})
     */
    protected $items;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\ShoppingCart\ShoppingCart")
     */
    protected $shoppingCart;

    /**
     * @ORM\Column(type="string")
     */
    protected $status = OrderStatus::STATUS_NEW;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Order\TrackingStatus\OrderTrackingStatus")
     */
    protected $trackingStatus;

    /**
     * @ORM\OneToOne(targetEntity="Vinci\Domain\Order\History\OrderHistory", mappedBy="order", cascade={"persist"})
     */
    protected $history;

    public function __construct()
    {
        $this->payments = new ArrayCollection;
        $this->items = new ArrayCollection;
        $this->history = new OrderHistory($this);

        $this->raise(new NewOrderWasCreated($this));
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNumber()
    {
        return $this->number;
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

    public function setItems(ArrayCollection $items)
    {
        $this->items->clear();

        foreach ($items as $item) {
            $this->addItem($item);
        }

        return $this;
    }

    public function addItem(OrderItem $item)
    {
        if (! $this->hasItem($item)) {

            $item->setOrder($this);

            $this->items->add($item);

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
        $this->calculateItemsTotal();

        $this->total = $this->itemsTotal;

        if ($this->hasShipment()) {
            $this->total += $this->getShipment()->getAmount();
        }
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

    public function addPayment(PaymentInterface $payment)
    {
        if (! $this->hasPayment($payment)) {
            $payment->setOrder($this);
            $this->payments->add($payment);
        }
    }

    public function hasPayment(PaymentInterface $payment)
    {
        return $this->payments->contains($payment);
    }

    public function getShipment()
    {
        return $this->shipment;
    }

    public function hasShipment()
    {
        return ! empty($this->shipment);
    }

    public function setShipment(ShipmentInterface $shipment)
    {
        $shipment->setOrder($this);
        $this->shipment = $shipment;

        $this->calculateTotal();

        return $this;
    }

    public function getShippingWeight()
    {
        $totalWeight = 0;

        foreach ($this->getItems() as $item) {
            $variant = $item->getProductVariant();
            $weight = $variant->getDimension()->getWeight();

            $totalWeight += $weight * $item->getQuantity();
        }

        return (double) $totalWeight;
    }

    public function getDeadline()
    {
        $maxDeadline = 0;

        foreach ($this->getItems() as $item) {

            $variant = $item->getProductVariant();
            $deadline = $variant->getShippingMetrics()->getDeadline();

            if ($deadline > $maxDeadline) {
                $maxDeadline = $deadline;
            }
        }

        return $maxDeadline;
    }

    public function getPayment()
    {
        return $this->payments->first();
    }

    public function getShoppingCart()
    {
        return $this->shoppingCart;
    }

    public function setShoppingCart(ShoppingCartInterface $cart = null)
    {
        $this->shoppingCart = $cart;
        return $this;
    }

    public function hasShoppingCart()
    {
        return !is_null($this->shoppingCart);
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

    public function isOwnedBy(CustomerInterface $customer)
    {
        return $this->customer->getId() == $customer->getId();
    }

    /** @ORM\PrePersist */
    public function generateOrderNumber()
    {
        $this->number = app(OrderNumberGenerator::class)->generate();
    }

    public function getPayments()
    {
        return $this->payments;
    }

    public function setPayments(ArrayCollection $payments)
    {
        $this->payments = $payments;
        return $this;
    }

    public function getTrackingStatus()
    {
        return $this->trackingStatus;
    }

    public function setTrackingStatus(OrderTrackingStatus $trackingStatus)
    {
        $this->trackingStatus = $trackingStatus;
        return $this;
    }

    public function getHistory()
    {
        return $this->history;
    }

    public function setHistory(OrderHistory $history)
    {
        $this->history = $history;
        return $this;
    }

    public function changeStatus($status)
    {
        $oldStatus = $this->getStatus();

        $this->setStatus($status);

        $this->raise(new OrderStatusWasChanged($this, $oldStatus));
    }

    public function changePaymentStatus($status)
    {
        $payment = $this->getPayment();

        $oldStatus = $payment->getStatus();

        $payment->setStatus($status);

        $this->raise(new PaymentStatusWasChanged($payment, $oldStatus));
    }

    public function changeTrackingStatus(OrderTrackingStatus $status)
    {
        $oldStatus = $this->getTrackingStatus();

        $this->setTrackingStatus($status);

        $this->raise(new OrderTrackingStatusWasChanged($this, $oldStatus));
    }

    public function __sleep()
    {
        app('em')->detach($this);

        return ['id', 'number', 'customer', 'channel', 'total', 'itemsTotal', 'shippingAddress', 'billingAddress', 'payments', 'shipment'];
    }

}
<?php

namespace Vinci\Domain\ShoppingCart;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Vinci\Domain\Common\Event\HasEvents;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\ShoppingCart\Events\ItemWasRemoved;
use Vinci\Domain\ShoppingCart\Events\NewItemWasAdded;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="shopping_cart")
 */
class ShoppingCart implements ShoppingCartInterface
{
    use Timestampable, HasEvents;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Customer\Customer", inversedBy="shoppingCarts")
     */
    protected $customer;

    /**
     * @ORM\Column(type="smallint", options={"defalut" = 1})
     */
    protected $status = 1;

    /**
     * @ORM\Column(name="expiration_at", type="datetime", nullable=true)
     */
    protected $expirationAt;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\ShoppingCart\Item\ShoppingCartItem", mappedBy="shoppingCart", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    protected $items;

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->items = new ArrayCollection;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = (int) $status;
        return $this;
    }

    public function getExpirationAt()
    {
        return $this->expirationAt;
    }

    public function setExpirationAt(Carbon $expirationAt = null)
    {
        $this->expirationAt = $expirationAt;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function hasItems()
    {
        return $this->items->count() > 0;
    }

    public function isEmpty()
    {
        return ! $this->hasItems();
    }

    public function addItem(ShoppingCartItem $cartItem)
    {
        if (! $this->hasItem($cartItem)) {
            $cartItem->setShoppingCart($this);
            $this->items->add($cartItem);

            $this->raise(new NewItemWasAdded($cartItem));
        }

        return $this;
    }

    public function addItemOrSyncQuantity(ShoppingCartItem $cartItem, $quantity = 1)
    {
        if (! $this->hasItem($cartItem)) {
            return $this->addItem($cartItem, $quantity);
        }

        $cartItem->syncQuantity($quantity);

        return $this;
    }

    public function getItemById($itemId)
    {
        foreach ($this->items as $item) {

            if ($item->getId() == $itemId) {
                return $item;
            }
        }
    }

    public function removeItem(ShoppingCartItem $cartItem)
    {
        if ($this->hasItem($cartItem)) {
            $this->items->removeElement($cartItem);

            $this->raise(new ItemWasRemoved($cartItem));
        }

        return $this;
    }

    public function hasItem(ShoppingCartItem $cartItem)
    {
        return $this->items->contains($cartItem);
    }

    public function findItemByProduct(ProductInterface $product)
    {
        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq('product', $product));

        return $this->items->matching($criteria)->first();
    }

    public function findItemById($id)
    {
        foreach ($this->getItems() as $item) {

            if ($item->getId() == $id) {
                return $item;
            }
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

    public function getSubtotal()
    {
        $sum = 0;

        foreach ($this->getItems() as $item) {
            $sum += $item->getSubtotal();
        }

        return $sum;
    }

    public function getTotal()
    {
        return $this->getSubtotal();
    }

    public function countItems()
    {
        $count = 0;

        foreach ($this->getItems() as $item) {
            $count += $item->getQuantity();
        }

        return $count;
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
}
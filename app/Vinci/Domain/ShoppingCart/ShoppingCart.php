<?php

namespace Vinci\Domain\ShoppingCart;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\ShoppingCart\Item\ShoppingCartItem;

/**
 * @ORM\Entity
 * @ORM\Table(name="shopping_cart", indexes={@ORM\Index(name="session_idx", columns={"session_id"})})
 */
class ShoppingCart implements ShoppingCartInterface
{
    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=40, options={"fixed" = true})
     */
    protected $sessionId;

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\ShoppingCart\Item\ShoppingCartItem", mappedBy="shoppingCart", cascade={"persist", "remove"})
     */
    protected $items;

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

    public function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->items = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSessionId()
    {
        return $this->sessionId;
    }

    public function setSessionId($sessionId)
    {
        $this->sessionId = $sessionId;
        return $this;
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

    public function addItem(ShoppingCartItem $cartItem)
    {
        if (! $this->hasItem($cartItem)) {
            $cartItem->setShoppingCart($this);
            $this->items->add($cartItem);
        }

        return $this;
    }

    public function removeItem(ShoppingCartItem $cartItem)
    {
        if ($this->hasItem($cartItem)) {
            $this->items->remove($cartItem);
        }

        return $this;
    }

    public function hasItem(ShoppingCartItem $cartItem)
    {
        return $this->items->contains($cartItem);
    }

}
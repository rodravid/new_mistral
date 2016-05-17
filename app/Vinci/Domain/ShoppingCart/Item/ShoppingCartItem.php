<?php

namespace Vinci\Domain\ShoppingCart\Item;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\ProductVariantInterface;
use Vinci\Domain\ShoppingCart\ShoppingCart;

/**
 * @ORM\Entity
 * @ORM\Table(name="shopping_cart_items")
 */
class ShoppingCartItem
{

    use Timestampable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\ShoppingCart\ShoppingCart", inversedBy="items")
     */
    protected $shoppingCart;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product")
     */
    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\ProductVariant")
     */
    protected $productVariant;

    /**
     * @ORM\Column(type="integer", options={"default" = 0})
     */
    protected $quantity = 0;

    /**
     * @ORM\Column(name="in_clearance_sale", type="boolean", options={"default" = 0})
     */
    protected $inClearanceSale = false;

    /**
     * @ORM\Column(type="smallint", options={"defalut" = 1})
     */
    protected $status = 1;

    public function getShoppingCart()
    {
        return $this->shoppingCart;
    }

    public function setShoppingCart(ShoppingCart $shoppingCart)
    {
        $this->shoppingCart = $shoppingCart;
        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
        return $this;
    }

    public function getProductVariant()
    {
        return $this->productVariant;
    }

    public function setProductVariant(ProductVariantInterface $productVariant)
    {
        $this->productVariant = $productVariant;
        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = (int) $quantity;
        return $this;
    }

    public function isInClearanceSale()
    {
        return $this->inClearanceSale;
    }

    public function setInClearanceSale($inClearanceSale)
    {
        $this->inClearanceSale = (bool) $inClearanceSale;
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

    public function incrementQuantity($quantity = 1)
    {
        $this->setQuantity($this->getQuantity() + intval($quantity));
        return $this;
    }

    public function decrementQuantity($quantity = 1)
    {
        $this->setQuantity($this->getQuantity() - intval($quantity));
        return $this;
    }

    public function getSubTotal()
    {
        return $this->getQuantity() * $this->getProductVariant()->getSalePrice();
    }

}
<?php

namespace Vinci\Domain\ShoppingCart\Item;

use Doctrine\ORM\Mapping as ORM;
use Robbo\Presenter\Robbo;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Common\Event\HasEvents;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Product\ProductVariantInterface;
use Vinci\Domain\ShoppingCart\Events\ItemQuantityWasIncremented;
use Vinci\Domain\ShoppingCart\ShoppingCart;

/**
 * @ORM\Entity
 * @ORM\Table(name="shopping_cart_items")
 */
class ShoppingCartItem extends Model implements ShoppingCartItemInterface
{

    use Timestampable, HasEvents, PresentableTrait;

    protected $presenter = ShoppingCartItemPresenter::class;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\ShoppingCart\ShoppingCart", inversedBy="items")
     * @ORM\JoinColumn(name="shopping_cart_id", onDelete="CASCADE")
     */
    protected $shoppingCart;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product", cascade={"persist"})
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

    public function getId()
    {
        return $this->id;
    }

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

    public function getProductVariant()
    {
        return $this->productVariant;
    }

    public function setProductVariant(ProductVariantInterface $productVariant)
    {
        $this->productVariant = $productVariant;
        $this->product = $productVariant->getProduct();

        $this->setInClearanceSale($this->product->isInClearanceSale());

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
        $quantity = intval($quantity);

        $this->setQuantity($this->getQuantity() + $quantity);

        $this->raise(new ItemQuantityWasIncremented($this, $quantity));

        return $this;
    }

    public function decrementQuantity($quantity = 1)
    {
        $quantity = intval($quantity);

        $this->setQuantity($this->getQuantity() - $quantity);

        $this->raise(new ItemQuantityWasIncremented($this, $quantity));

        return $this;
    }

    public function syncQuantity($quantity = 1)
    {
        $currentQuantity = $this->getQuantity();

        if ($quantity > $currentQuantity) {

            $quantity -= $currentQuantity;

            return $this->incrementQuantity($quantity);

        } elseif ($quantity < $currentQuantity) {

            $quantity = $currentQuantity - $quantity;

            return $this->decrementQuantity($quantity);
        }

        return $this;
    }

    public function equals(ShoppingCartItem $cartItem)
    {
        return $this === $cartItem;
    }

    public function getSubTotal()
    {
        return $this->getQuantity() * $this->getProductVariant()->getSalePrice();
    }

    public function __call($name, array $args = [])
    {
        return call_user_func_array([$this->productVariant, $name], $args);
    }

    public function __get($name)
    {
        dd($name);
    }

    public function getPresenter()
    {
        return $this->present();
    }
}
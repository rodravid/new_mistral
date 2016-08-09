<?php

namespace Vinci\Domain\Order\Item;

use Doctrine\ORM\Mapping as ORM;
use Robbo\Presenter\Robbo;
use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Common\Event\HasEvents;
use Vinci\Domain\Common\Traits\HasIntegrationStatus;
use Vinci\Domain\Common\Traits\Timestampable;
use Vinci\Domain\Core\Model;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\Order\Presenter\OrderItemPresenter;
use Vinci\Domain\Product\ProductVariantInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="orders_items")
 */
class OrderItem extends Model implements Presentable
{

    use Timestampable, HasEvents, PresentableTrait, HasIntegrationStatus;

    protected $presenter = OrderItemPresenter::class;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Order\Order", inversedBy="items")
     */
    protected $order;

    /**
     * @ORM\Column(type="integer")
     */
    protected $quantity = 1;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $originalPrice;

    /**
     * @ORM\Column(name="aliquot_ipi", type="decimal", precision=13, scale=2, nullable=true)
     */
    protected $aliquotIpi;

    /**
     * @ORM\Column(type="decimal", precision=13, scale=2)
     */
    protected $total;

    /**
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\ProductVariant")
     * @ORM\JoinColumn(name="product_variant_id", referencedColumnName="id", onDelete="CASCADE", nullable=false)
     */
    protected $productVariant;

    public function getId()
    {
        return $this->id;
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

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(OrderInterface $order)
    {
        $this->order = $order;
        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function getOriginalPrice()
    {
        return $this->originalPrice;
    }

    public function setOriginalPrice($originalPrice)
    {
        $this->originalPrice = $originalPrice;
        return $this;
    }

    public function getAliquotIpi()
    {
        return (double) $this->aliquotIpi;
    }

    public function setAliquotIpi($aliquotIpi)
    {
        $this->aliquotIpi = $aliquotIpi;
        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;
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

}
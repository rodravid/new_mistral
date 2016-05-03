<?php

namespace Vinci\Domain\Product\Kit;

use Doctrine\ORM\Mapping as ORM;
use Vinci\Domain\Product\Product;

/**
 * @ORM\Entity
 * @ORM\Table(name="kit_items")
 */
class KitItem
{

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Kit\Kit", inversedBy="items")
     * @ORM\JoinColumn(name="kit_id", referencedColumnName="id", nullable=false)
     */
    protected $kit;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Vinci\Domain\Product\Product")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id", nullable=false)
     */
    protected $product;

    /**
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    public function getKit()
    {
        return $this->kit;
    }

    public function setKit(Kit $kit)
    {
        $this->kit = $kit;
        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product = null)
    {
        $this->product = $product;
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

}
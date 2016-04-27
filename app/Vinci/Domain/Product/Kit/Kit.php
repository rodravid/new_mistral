<?php

namespace Vinci\Domain\Product\Kit;

use Vinci\Domain\Product\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Kit extends Product
{

    /**
     * @ORM\ManyToMany(targetEntity="Vinci\Domain\Product\Product")
     * @ORM\JoinTable(name="kits_products",
     *      joinColumns={@ORM\JoinColumn(name="kit_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")}
     *      )
     */
    protected $items;

    /**
     * @ORM\Column(name="fixed_price", type="boolean", options={"default" = 0})
     */
    protected $fixedPrice = false;

    public function getItems()
    {
        return $this->items;
    }

    public function getPrice()
    {
        if ($this->fixedPrice) {
            return parent::getPrice();
        }
    }

}
<?php

namespace Vinci\Domain\Product\Kit;

use Doctrine\Common\Collections\ArrayCollection;
use Vinci\Domain\Product\Product;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Kit extends Product
{

    /**
     * @ORM\OneToMany(targetEntity="Vinci\Domain\Product\Kit\KitItem", mappedBy="kit")
     */
    protected $items;

    /**
     * @ORM\Column(name="fixed_price", type="boolean", options={"default" = 0})
     */
    protected $fixedPrice = false;

    public function __construct()
    {
        parent::__construct();

        $this->items = new ArrayCollection;
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
    }

    public function addItem(KitItem $item)
    {
        if (! $this->hasItem($item)) {
            $item->setKit($this);
            $this->items->add($item);
        }
    }

    public function removeItem(KitItem $item)
    {
        if ($this->hasItem($item)) {
            $item->setProduct(null);
            $this->items->removeElement($item);
        }
    }

    public function hasItem(KitItem $item)
    {
        return $this->items->contains($item);
    }

    public function getPrice()
    {
        if ($this->fixedPrice) {
            return parent::getPrice();
        }
    }

}
<?php

namespace Vinci\Domain\ERP\Order\Item;

use Spatie\Fractal\Fractal;
use Vinci\Domain\Order\Item\OrderItem;

class ItemTranslator
{

    protected $itemFactory;

    protected $fractal;

    public function __construct(ItemFactory $itemFactory, Fractal $fractal)
    {
        $this->itemFactory = $itemFactory;
        $this->fractal = $fractal;
    }

    public function translate(OrderItem $localItem)
    {
        $item = $this->itemFactory->getNewInstance();

        $attributes = $this->getAttributesFrom($localItem);

        $item->fill($attributes);

        return $item;
    }

    public function getAttributesFrom(OrderItem $localItem)
    {
        return $this->fractal
            ->item($localItem)
            ->transformWith(new ItemTransformer)
            ->toArray();
    }

}
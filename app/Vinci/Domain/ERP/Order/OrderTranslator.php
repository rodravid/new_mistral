<?php

namespace Vinci\Domain\ERP\Order;

use Spatie\Fractal\Fractal;
use Vinci\Domain\Order\OrderInterface;

class OrderTranslator
{

    protected $orderFactory;

    protected $fractal;

    public function __construct(OrderFactory $orderFactory, Fractal $fractal)
    {
        $this->orderFactory = $orderFactory;
        $this->fractal = $fractal;
    }

    public function translate(OrderInterface $localOrder)
    {
        $order = $this->orderFactory->getNewInstance();

        $attributes = $this->getAttributesFrom($localOrder);

        $order->fill($attributes);

        return $order;
    }

    public function getAttributesFrom(OrderInterface $localOrder)
    {
        return $this->fractal
            ->item($localOrder)
            ->transformWith(new OrderTransformer)
            ->toArray();
    }

}
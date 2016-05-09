<?php

namespace Vinci\Domain\Product\Events\Subscribers;

use Vinci\Domain\Pricing\Contracts\PriceCalculatorProvider;

class SetPriceCalculatorSubscriber
{

    private $calculatorProvider;

    public function __construct(PriceCalculatorProvider $calculatorProvider)
    {
        $this->calculatorProvider = $calculatorProvider;
    }

    public function onProductLoaded($event)
    {
        $product = $event->product;

        $product->setPriceCalculator($this->calculatorProvider->getCalculator());
    }

    public function subscribe($events)
    {
        $events->listen(
            'Vinci\Domain\Product\Events\ProductWasLoaded',
            'Vinci\Domain\Product\Events\Subscribers\SetPriceCalculatorSubscriber@onProductLoaded'
        );
    }

}
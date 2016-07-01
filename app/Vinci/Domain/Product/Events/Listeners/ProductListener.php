<?php

namespace Vinci\Domain\Product\Events\Listeners;

use Vinci\Domain\Channel\Contracts\ChannelProvider;
use Vinci\Domain\Pricing\Contracts\PriceCalculatorProvider;
use Vinci\Domain\Product\Product;

class ProductListener
{

    private $channelProvider;

    private $calculatorProvider;

    public function __construct(ChannelProvider $channelProvider, PriceCalculatorProvider $calculatorProvider)
    {
        $this->channelProvider = $channelProvider;
        $this->calculatorProvider = $calculatorProvider;
    }

    public function postLoad(Product $product)
    {
        $product->setCurrentChannel($this->channelProvider->getChannel());
        $product->setPriceCalculator($this->calculatorProvider->getCalculator());
    }

}
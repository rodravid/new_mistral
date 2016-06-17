<?php

namespace Vinci\Domain\Pricing\Calculator;

use Illuminate\Contracts\Container\Container;
use Vinci\Domain\Pricing\Contracts\PriceCalculatorProvider as PriceCalculatorProviderInterface;
use Vinci\Domain\Pricing\Providers\StandardPriceConfigurationProvider;

class PriceCalculatorProvider implements PriceCalculatorProviderInterface
{

    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function getCalculator()
    {
        return $this->container->make(StandardPriceCalculator::class);
    }

    public function getPriceConfigurationResolver()
    {
        return function($productVariantPrice) {

            $provider = $this->container->make(StandardPriceConfigurationProvider::class);

            $provider->setProductVariantPrice($productVariantPrice);

            return $provider;
        };
    }
}
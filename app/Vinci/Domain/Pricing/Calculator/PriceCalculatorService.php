<?php

namespace Vinci\Domain\Pricing\Calculator;

use Vinci\Domain\Pricing\Calculator\Exceptions\PriceCalculatorException;
use Vinci\Domain\Pricing\Contracts\Priceable;

class PriceCalculatorService
{
    private $priceCalculator;

    public function __construct(PriceCalculator $priceCalculator)
    {
        $this->priceCalculator = $priceCalculator;
    }

    public function definePriceCalculator(Priceable $subject)
    {
        return $this->priceCalculator->calculate($subject);
    }

    public function getOriginalPriceFor(Priceable $subject)
    {
        return $this->priceCalculator->skiptDiscounts()->calculate($subject);
    }

    public function calculateSalePrices($subject)
    {
        if ($this->isIterable($subject)) {
            foreach ($subject as $item) {
                $this->calculate($item);
            }
        }

        $this->assertPriceable($subject);

        $salePrice = $this->getPriceFor($subject);
        $originalSalePrice = $this->getOriginalPriceFor($subject);

        $subject->setSalePrice($salePrice);
        $subject->setOriginalSalePrice($originalSalePrice);
    }

    private function isIterable($subject)
    {
        return is_array($subject) || $subject instanceof \Traversable;
    }

    private function assertPriceable($subject)
    {
        if (! $subject instanceof Priceable) {
            throw new PriceCalculatorException(sprintf('Subject must be instnace of %s', Priceable::class));
        }
    }

}
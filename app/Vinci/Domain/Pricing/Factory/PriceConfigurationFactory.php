<?php

namespace Vinci\Domain\Pricing\Factory;

use Vinci\Domain\Pricing\PriceConfiguration;
use Vinci\Domain\Product\ProductVariantPrice;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionInterface;

class PriceConfigurationFactory
{

    public function makeFromDiscountPromotion(DiscountPromotionInterface $discountPromotion)
    {
        $priceConfiguration = $this->getNewInstance();

        $priceConfiguration
            ->setDiscountType($discountPromotion->getDiscountType())
            ->setDiscountAmount($discountPromotion->getDiscountAmount());

        if ($discountPromotion->getDiscountType() == 'exchange-rate') {

            $priceConfiguration
                ->setCurrencyAmount($discountPromotion->getCurrencyAmount())
                ->setCurrencyOriginalAmount($discountPromotion->getCurrencyOriginalAmount());
        }

        return $priceConfiguration;
    }

    public function makeFromProductVariantPrice(ProductVariantPrice $variantPrice)
    {
        return
            $this->getNewInstance()
            ->setAliquotIpi($variantPrice->getAliquotIpi())
            ->setCurrencyAmount($variantPrice->getCurrencyAmount())
            ->setCurrencyOriginalAmount($variantPrice->getCurrencyOriginalAmount())
            ->setDiscountType($variantPrice->getDiscountType())
            ->setDiscountAmount($variantPrice->getDiscountAmount());
    }

    public function getNewInstance()
    {
        return new PriceConfiguration;
    }

}
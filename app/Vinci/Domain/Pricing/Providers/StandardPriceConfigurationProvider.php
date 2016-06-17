<?php

namespace Vinci\Domain\Pricing\Providers;

use Vinci\Domain\Pricing\Contracts\PriceConfigurationProvider;
use Vinci\Domain\Pricing\Factory\PriceConfigurationFactory;
use Vinci\Domain\Product\ProductVariantPrice;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionService;

class StandardPriceConfigurationProvider extends AbstractPriceConfigurationProvider implements PriceConfigurationProvider
{

    protected $discountPromotionService;

    protected $productVariantPrice;

    public function __construct(PriceConfigurationFactory $priceConfigurationFactory, DiscountPromotionService $discountPromotionService)
    {
        parent::__construct($priceConfigurationFactory);

        $this->discountPromotionService = $discountPromotionService;
    }

    public function setProductVariantPrice(ProductVariantPrice $productVariantPrice)
    {
        $this->productVariantPrice = $productVariantPrice;
    }

    public function getConfiguration()
    {
        $variant = $this->productVariantPrice->getVariant();
        $product = $variant->getProduct();

        if ($promotion = $this->discountPromotionService->findValidPromotionFor($product)) {
            $configuration =  $this->configurationFactory->makeFromDiscountPromotion($promotion);

            $configuration->setAliquotIpi($this->productVariantPrice->getAliquotIpi());

            return $configuration;
        }

        return $this->configurationFactory->makeFromProductVariantPrice($this->productVariantPrice);
    }

}
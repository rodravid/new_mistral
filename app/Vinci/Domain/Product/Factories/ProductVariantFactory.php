<?php

namespace Vinci\Domain\Product\Factories;

use Vinci\Domain\Product\ProductVariant;

class ProductVariantFactory
{

    protected $productPriceFactory;

    public function __construct(ProductPriceFactory $productPriceFactory)
    {
        $this->productPriceFactory = $productPriceFactory;
    }

    public function make(array $data)
    {
        $variant = new ProductVariant;

        $this->includePrices($variant, $data);

        $variant
            ->setTitle($data['title'])
            ->setDescription($data['description'])
            ->setShortDescription($data['shortDescription'])
            ->setStatus($data['status'])
            ->setStock($data['stock'])
            ->setStartsAtFromFormat($data['startsAt'])
            ->setExpirationAtFromFormat($data['expirationAt']);

        return $variant;
    }

    public function includePrices($variant, array $data)
    {
        if (isset($data['price'])) {

            $prices = $this->productPriceFactory->makeCollection($data['price']);

            foreach ($prices as $price) {
                $variant->addPrice($price);
            }
        }
    }

}
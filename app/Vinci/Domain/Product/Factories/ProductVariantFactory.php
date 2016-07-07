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
            ->setSeoTitle($data['seoTitle'])
            ->setSeoDescription($data['seoDescription'])
            ->setSeoKeywords($data['seoKeywords'])
            ->setDescription($data['description'])
            ->setShortDescription($data['shortDescription'])
            ->setStatus($data['status'])
            ->setStock(array_get($data, 'stock'))
            ->setImportPrice(array_get($data, 'should_import_price'))
            ->setImportStock(array_get($data, 'should_import_stock'))
            ->setStartsAtFromFormat($data['startsAt'])
            ->setExpirationAtFromFormat($data['expirationAt'])
            ->setPackSize($data['packSize']);

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
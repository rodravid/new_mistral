<?php

namespace Vinci\Domain\Product\Factories;

use Vinci\Domain\Grape\GrapeFactory;
use Vinci\Domain\Product\Factories\Contracts\ProductFactory as ProductFactoryInterface;
use Vinci\Domain\Product\Kit\Kit;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\ProductType;
use Vinci\Domain\Product\Wine\Score\ScoreFactory;
use Vinci\Domain\Product\Wine\Wine;

class ProductFactory implements ProductFactoryInterface
{

    private $variantFactory;

    private $productTypeFactory;
   
    private $grapeFactory;
    
    private $scoreFactory;

    private $attributeFactory;

    public function __construct(
        ProductVariantFactory $variantFactory,
        ProductTypeFactory $productTypeFactory,
        GrapeFactory $grapeFactory,
        ScoreFactory $scoreFactory,
        AttributeFactory $attributeFactory
    )
    {
        $this->variantFactory = $variantFactory;
        $this->productTypeFactory = $productTypeFactory;
        $this->grapeFactory = $grapeFactory;
        $this->scoreFactory = $scoreFactory;
        $this->attributeFactory = $attributeFactory;
    }

    public function make(array $data)
    {
        $productType = $this->productTypeFactory->make($data['type']);

        $variant = $this->variantFactory->make($data);

        $product = $this->getInstanceFromType($productType->getCode());

        $product
            ->setArchType($productType)
            ->setMasterVariant($variant)
            ->setStatus($data['status'])
            ->setStartsAtFromFormat($data['startsAt'])
            ->setExpirationAtFromFormat($data['expirationAt']);

        $this->includeAttributes($product, $data);

        if ($product->isType(ProductType::TYPE_WINE)) {

            $this->includeGrapes($product, $data);

            $this->includeScores($product, $data);
        }

        return $product;
    }

    protected function includeAttributes(Product $product, $data)
    {
        if (isset($data['attributes'])) {
            $attributes = $this->attributeFactory->makeCollection($data['attributes']);
            $product->setAttributes($attributes);
        }
    }

    protected function includeGrapes($product, array $data)
    {
        if (isset($data['grapes'])) {

            foreach ($data['grapes'] as $item) {
                $grape = $this->grapeFactory->make($item);
                $product->addGrape($grape, $item['weight']);
            }
        }
    }

    protected function includeScores($product, array $data)
    {
        if (isset($data['scores'])) {
            $scores = $this->scoreFactory->makeCollection($data['scores']);

            foreach ($scores as $score) {
                $product->addScore($score);
            }
        }
    }

    public function override(Product $product, array $data)
    {
        $newProduct = $this->make($data);

        $product
            ->setTitle($newProduct->getTitle())
            ->setDescription($newProduct->getDescription())
            ->setShortDescription($newProduct->getShortDescription())
            ->setStatus($newProduct->getStatus())
            ->syncAttributes($newProduct->getAttributes())
            ->syncChannels($newProduct->getChannels())
            ->syncScores($newProduct->getScores())
            ->syncPrices($newProduct->getPrices())
            ->setStock($newProduct->getStock())
            ->setSeoTitle($newProduct->getSeoTitle())
            ->setSeoDescription($newProduct->getSeoDescription())
            ->setSeoKeywords($newProduct->getSeoKeywords())
            ->setSlug($newProduct->getSlug())
            ->setSku($newProduct->getSku())
            ->setStartsAt($newProduct->getStartsAt())
            ->setExpirationAt($newProduct->getExpirationAt())
            ->setOnline($newProduct->isOnline())
            ->setImportStock($newProduct->shouldImportStock())
            ->setImportPrice($newProduct->shouldImportPrice())
        ;

        if ($product->isType(ProductType::TYPE_WINE)) {
            $product->syncGrapeContent($newProduct->getGrapes());
        }

        return $product;
    }

    public function getInstanceFromType($type)
    {
        switch ($type) {

            case ProductType::TYPE_WINE:
                return new Wine;
                break;

            case ProductType::TYPE_PRODUCT:
                return new Product;
                break;

            case ProductType::TYPE_KIT:
                return new Kit;
                break;

        }
    }

}
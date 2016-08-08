<?php

namespace Vinci\Domain\Product\Factories;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Grape\GrapeFactory;
use Vinci\Domain\Producer\Producer;
use Vinci\Domain\Product\Dimension;
use Vinci\Domain\Product\Factories\Contracts\ProductFactory as ProductFactoryInterface;
use Vinci\Domain\Product\Kit\Kit;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\ProductType as ProductArchType;
use Vinci\Domain\Product\Wine\Score\ScoreFactory;
use Vinci\Domain\Product\Wine\Wine;
use Vinci\Domain\ProductType\ProductType;
use Vinci\Domain\Region\Region;
use Vinci\Domain\Product\Factories\ProductTypeFactory as ProductArchTypeFactory;

class ProductFactory implements ProductFactoryInterface
{

    private $entityManager;

    private $variantFactory;

    private $productArchTypeFactory;

    private $grapeFactory;

    private $scoreFactory;

    private $attributeFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductVariantFactory $variantFactory,
        ProductArchTypeFactory $productArchTypeFactory,
        GrapeFactory $grapeFactory,
        ScoreFactory $scoreFactory,
        AttributeFactory $attributeFactory
    )
    {
        $this->entityManager = $entityManager;
        $this->variantFactory = $variantFactory;
        $this->productArchTypeFactory = $productArchTypeFactory;
        $this->grapeFactory = $grapeFactory;
        $this->scoreFactory = $scoreFactory;
        $this->attributeFactory = $attributeFactory;
    }

    public function make(array $data)
    {
        $productType = $this->productArchTypeFactory->make($data['type']);

        $variant = $this->variantFactory->make($data);

        $product = $this->getInstanceFromType($productType->getCode());

        $product
            ->setOnline(array_get($data, 'online', false))
            ->setArchType($productType)
            ->setMasterVariant($variant)
            ->setSku($data['sku'])
            ->setStatus($data['status'])
            ->setStartsAtFromFormat($data['startsAt'])
            ->setExpirationAtFromFormat($data['expirationAt'])
            ->setEnabledForPromotions(array_get($data, 'enabled_for_promotions'));

        $this->includeCountry($product, $data);
        $this->includeRegion($product, $data);
        $this->includeProducer($product, $data);
        $this->includeProductType($product, $data);
        $this->includeAttributes($product, $data);
        $this->includeChannels($product, $data);
        $this->includeDimension($product, $data);

        if ($product->isType(ProductArchType::TYPE_WINE)) {

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
        if (isset($data['grapes']) && ! empty($data['grapes'])) {

            foreach ($data['grapes'] as $item) {
                $grape = $this->grapeFactory->make($item);
                $product->addGrape($grape, $item['weight']);
            }
        }
    }

    protected function includeScores(Product $product, array $data)
    {
        if (isset($data['scores'])) {
            $scores = $this->scoreFactory->makeCollection($data['scores']);

            foreach ($scores as $score) {
                $product->addScore($score);
            }
        }
    }

    protected function includeChannels(Product $product, $data)
    {
        if (isset($data['channels']) && ! empty($data['channels'])) {
            foreach ($data['channels'] as $channel) {
                $product->addChannel($this->entityManager->getReference(Channel::class, $channel));
            }
        }
    }

    protected function includeDimension(Product $product, $data)
    {
        if (isset($data['dimension'])) {

            $dimension = new Dimension;
            
            $dimension->setWidth(array_get($data, 'width', $product->getDimension()->getWidth()));
            $dimension->setHeight(array_get($data, 'height', $product->getDimension()->getHeight()));
            $dimension->setWeight(array_get($data, 'weight', $product->getDimension()->getWeight()));
            $dimension->setLength(array_get($data, 'length', $product->getDimension()->getLength()));

            $product->setDimension($dimension);
        }
    }

    protected function includeCountry(Product $product, $data)
    {
        if (isset($data['country_id']) && ! empty($data['country_id'])) {
            $product->setCountry($this->entityManager->getReference(Country::class, $data['country_id']));
        }
    }

    protected function includeRegion(Product $product, $data)
    {
        if (isset($data['region_id']) && ! empty($data['region_id'])) {
            $product->setRegion($this->entityManager->getReference(Region::class, $data['region_id']));
        }
    }

    protected function includeProducer(Product $product, $data)
    {
        if (isset($data['producer_id']) && ! empty($data['producer_id'])) {
            $product->setProducer($this->entityManager->getReference(Producer::class, $data['producer_id']));
        }
    }

    protected function includeProductType(Product $product, $data)
    {
        if (isset($data['product_type_id']) && ! empty($data['product_type_id'])) {
            $product->setProductType($this->entityManager->getReference(ProductType::class, $data['product_type_id']));
        }
    }

    public function override(Product $product, array $data)
    {
        $newProduct = $this->make($data);

        $product
            ->setSku($newProduct->getSku())
            ->setTitle($newProduct->getTitle())
            ->setDescription($newProduct->getDescription())
            ->setShortDescription($newProduct->getShortDescription())
            ->setStatus($newProduct->getStatus())
            ->syncAttributes($newProduct->getAttributes())
            ->syncChannels($newProduct->getChannels())
            ->setSeoTitle($newProduct->getSeoTitle())
            ->setSeoDescription($newProduct->getSeoDescription())
            ->setSeoKeywords($newProduct->getSeoKeywords())
            ->setSlug($newProduct->getSlug())
            ->setSku($newProduct->getSku())
            ->setStartsAt($newProduct->getStartsAt())
            ->setExpirationAt($newProduct->getExpirationAt())
            ->setOnline($newProduct->isOnline())
            ->setPackSize($newProduct->getPackSize());

        if (array_has($data, 'stock')) {
            $product->setStock($newProduct->getStock());
        }

        if (array_has($data, 'should_import_stock')) {
            $product->setImportStock($newProduct->shouldImportStock());
        }

        if (array_has($data, 'price')) {
            $product->syncPrices($newProduct->getPrices());
        }

        if (array_has($data, 'should_import_price')) {
            $product->setImportPrice($newProduct->shouldImportPrice());
        }

        if (array_has($data, 'enabled_for_promotions')) {
            $product->setEnabledForPromotions($newProduct->canBePromoted());
        }

        if (! empty(array_get($data, 'country_id'))) {
            $product->setCountry($newProduct->getCountry());
        }

        if (! empty(array_get($data, 'region_id'))) {
            $product->setRegion($newProduct->getRegion());
        }

        if (! empty(array_get($data, 'producer_id'))) {
            $product->setProducer($newProduct->getProducer());
        }

        if (! empty(array_get($data, 'product_type_id'))) {
            $product->setProductType($newProduct->getProductType());
        }

        if ($product->isType(ProductArchType::TYPE_WINE)) {
            
            
            if (isset($data['scores'])) {
                $product->syncScores($newProduct->getScores());
            }

            if (isset($data['grapes'])) {
                $product->syncGrapeContent($newProduct->getGrapes());
            }
            
        }

        return $product;
    }

    public function getInstanceFromType($type)
    {
        switch ($type) {

            case ProductArchType::TYPE_WINE:
                return new Wine;
                break;

            case ProductArchType::TYPE_PRODUCT:
                return new Product;
                break;

            case ProductArchType::TYPE_KIT:
                return new Kit;
                break;

        }
    }

}
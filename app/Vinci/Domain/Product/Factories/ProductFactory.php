<?php

namespace Vinci\Domain\Product\Factories;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Grape\GrapeFactory;
use Vinci\Domain\Producer\Producer;
use Vinci\Domain\Product\Factories\Contracts\ProductFactory as ProductFactoryInterface;
use Vinci\Domain\Product\Kit\Kit;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\ProductType;
use Vinci\Domain\Product\Wine\Score\ScoreFactory;
use Vinci\Domain\Product\Wine\Wine;
use Vinci\Domain\Region\Region;

class ProductFactory implements ProductFactoryInterface
{

    private $entityManager;

    private $variantFactory;

    private $productTypeFactory;

    private $grapeFactory;

    private $scoreFactory;

    private $attributeFactory;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductVariantFactory $variantFactory,
        ProductTypeFactory $productTypeFactory,
        GrapeFactory $grapeFactory,
        ScoreFactory $scoreFactory,
        AttributeFactory $attributeFactory
    )
    {
        $this->entityManager = $entityManager;
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
            ->setSku($data['sku'])
            ->setStatus($data['status'])
            ->setStartsAtFromFormat($data['startsAt'])
            ->setExpirationAtFromFormat($data['expirationAt']);

        $this->includeCountry($product, $data);
        $this->includeRegion($product, $data);
        $this->includeProducer($product, $data);
        $this->includeAttributes($product, $data);
        $this->includeChannels($product, $data);

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
            ->setPackSize($newProduct->getPackSize());

        if ($product->isType(ProductType::TYPE_WINE)) {
            $product->syncScores($newProduct->getScores());
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
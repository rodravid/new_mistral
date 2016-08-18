<?php

namespace Vinci\Domain\Search\Product;

use Elasticsearch\Client;
use Exception;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Search\Exceptions\IndexingSpecificationException;
use Vinci\Domain\Search\Indexing\IndexingService;
use Vinci\Domain\Search\Product\Indexing\DefaultProductIndex;
use Vinci\Domain\Search\Product\Indexing\IndexManager;
use Vinci\Domain\Search\Product\Indexing\Specification\ProductIndexingSpecification;
use Vinci\Domain\Showcase\ShowcaseRepository;
use Vinci\Domain\Showcase\StaticShowcases\StaticShowcasesProvider;
use Vinci\Domain\Specification\AbstractSpecification;

class ProductIndexerService extends IndexingService
{

    private $productRepository;

    private $showcaseRepository;

    private $staticShowcasesProvider;
    
    protected $defaultIndex = DefaultProductIndex::class;

    public function __construct(
        Client $client,
        IndexManager $indexManager,
        ProductRepositoryInterface $productRepository,
        ShowcaseRepository $showcaseRepository,
        StaticShowcasesProvider $staticShowcasesProvider
    ) {
        parent::__construct($client, $indexManager);

        $this->productRepository = $productRepository;
        $this->showcaseRepository = $showcaseRepository;
        $this->staticShowcasesProvider = $staticShowcasesProvider;
    }

    public function syncOne($product, AbstractSpecification $indexingSpecification = null)
    {
        try {

            $product = $this->normalizeProduct($product);

            $this->checkSpecification($product, $this->normalizeIndexingSpecification($indexingSpecification));

            $params = [
                'index' => 'vinci',
                'type' => 'product',
                'id' => $product->getId(),
                'body' => $this->getDataForSearch($product)
            ];

            return $this->client->index($params);

        } catch (Exception $e) {

            $this->delete($product);

            throw $e;
        }
    }

    public function syncAll($indexingSpecification = null)
    {
        $indexingSpecification = $this->normalizeIndexingSpecification($indexingSpecification);
        $result = $this->productRepository->getProductsForIndexing();
        $params = [];
        $toDelete = [];

        foreach ($result as $row) {

            $product = $row[0];

            try {

                $this->checkSpecification($product, $indexingSpecification);

                $data = $this->getDataForSearch($product);

                $params['body'][] = [
                    'index' => [
                        '_index' => 'vinci',
                        '_type' => 'product',
                        '_id' => $product->getId()
                    ]
                ];

                $params['body'][] = $data;

            } catch (Exception $e) {
                $toDelete[] = $product->getId();
            }

            app('em')->detach($product);
        }

        $result = $this->client->bulk($params);

        $this->delete($toDelete);

        return $result;
    }

    public function delete($product)
    {
        if (is_array($product)) {

            foreach ($product as $p) {
                $this->delete($p);
            }

        } else {

            try {
                return $this->client->delete([
                    'index' => 'vinci',
                    'type' => 'product',
                    'id' => $product instanceof ProductInterface ? $product->getId() : $product
                ]);
            } catch (Exception $e) {
                //
            }

        }
    }

    public function getDataForSearch(ProductInterface $product)
    {
        $data = [
            'id' => $product->getId(),
            'sku' => $product->getSku(),
            'title' => $product->present()->title,
            'description' => $product->getDescription(),
            'short_description' => $product->getShortDescription(),
            'price' => $product->getSalePrice(),
            'available' => (int)$product->isAvailable(),
            'relevance' => $product->getSearchRelevance()
        ];

        if ($product->hasCountry()) {
            $country = $product->getCountry();

            $data['country'] = [
                'id' => $country->getId(),
                'title' => $country->getName()
            ];
        }

        if ($product->hasRegion()) {
            $region = $product->getRegion();

            $data['region'] = [
                'id' => $region->getId(),
                'title' => $region->getName(),
                'country' => 'Brasil'
            ];
        }

        if ($product->hasProducer()) {
            $producer = $product->getProducer();

            $data['producer'] = [
                'id' => $producer->getId(),
                'title' => $producer->getName()
            ];
        }

        if ($product->hasProductType()) {
            $productType = $product->getProductType();

            $data['product_type'] = [
                'id' => $productType->getId(),
                'title' => $productType->getName()
            ];
        }

        if ($product->isWine()) {
            foreach ($product->getGrapeContent() as $grapeContent) {
                $data['grapes'][] = [
                    'id' => $grapeContent->getGrape()->getId(),
                    'title' => $grapeContent->getGrape()->getName(),
                    'weight' => $grapeContent->getWeight()
                ];
            }
        }

        $data['keywords'] = $keywords = $product->getSeoKeywords();

        foreach ($this->showcaseRepository->getByProductAsArray($product) as $showcase) {

            $data['keywords'] .= $showcase['keywords'];

            $data['showcases'][] = $showcase;

        }

        foreach ($this->staticShowcasesProvider->getShowcases() as $showcase) {

            if ($showcase->isSatisfiedBy($product)) {

                $data['keywords'] .= $showcase->getKeywords();

                $data['showcases'][] = [
                    'id' => $showcase->getId(),
                    'title' => $showcase->getTitle(),
                    'keywords' => $showcase->getKeywords()
                ];
            }

        }

        $suggestInput = explode(' ', $product->getTitle());
        $suggestInput = array_merge($suggestInput, explode(',', $keywords));

        $data['suggest'] = [
            'input' => $suggestInput,
            'output' => $product->getTitle(),
            'payload' => [
                'productId' => $product->getId(),
                'url' => $product->getWebPath(),
                'producer' => ($product->hasProducer() ? $product->getProducer()->getName() : ''),
                'country' => $product->getCountry()->getName()
            ]
        ];

        if ($product->hasAttributes()) {
            $attributes = $product->getAttributes();

            foreach ($attributes as $attribute) {
                if (!empty($attribute->getValue())) {

                    if ($attribute->getAttribute()->getCode() == 'bottle_size' && !contains_numbers($attribute->getValue())) {
                        continue;
                    }

                    $data[$attribute->getAttribute()->getCode()] = $attribute->getValue();
                }
            }
        }

        return $data;
    }

    private function normalizeProduct($product)
    {
        if ($product instanceof ProductInterface) {
            return $product;
        }

        return $this->productRepository->getOneById($product);
    }

    private function checkSpecification(ProductInterface $product, AbstractSpecification $specification)
    {
        if (! $specification->isSatisfiedBy($product)) {
            throw new IndexingSpecificationException(
                sprintf('The product #%s can not be indexed or not is satisfied by indexing specification.', $product->getId())
            );
        }
    }

    private function normalizeIndexingSpecification($indexingSpecification = null)
    {
        if (! empty($indexingSpecification)) {
            return $indexingSpecification;
        }

        return new ProductIndexingSpecification;
    }

}
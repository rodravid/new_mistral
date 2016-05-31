<?php

namespace Vinci\Domain\Search\Product;

use Elasticsearch\Client;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Wine\Wine;

class ProductIndexerService
{

    private $client;

    private $productRepository;

    public function __construct(Client $client, ProductRepositoryInterface $productRepository)
    {
        $this->client = $client;
        $this->productRepository = $productRepository;
    }

    public function index(ProductInterface $product)
    {

    }

    public function indexAllProducts()
    {
        $query = $this->productRepository->getProductsForIndexing();

        $iterable = $query->iterate();

        foreach ($iterable as $item) {

            $product = $item[0];

            $params['body'][] = [
                'index' => [
                    '_index' => 'vinci',
                    '_type' => 'products',
                    '_id' => $product->getId()
                ]
            ];

            $data = [
                'id' => $product->getId(),
                'sku' => $product->getSku(),
                'title' => $product->getTitle(),
                'description' => $product->getDescription(),
                'price' => $product->getSalePrice()
            ];

            if ($product instanceof Wine) {

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
                        'title' => $region->getName()
                    ];
                }

                if ($product->hasProducer()) {
                    $producer = $product->getProducer();

                    $data['producer'] = [
                        'id' => $producer->getId(),
                        'title' => $producer->getName()
                    ];
                }

            }

            $params['body'][] = $data;
        }

        return $this->client->bulk($params);
    }


}
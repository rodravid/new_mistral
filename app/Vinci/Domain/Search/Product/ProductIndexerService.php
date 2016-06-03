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

    public function deleteIndex($name)
    {
        $this->client->indices()->delete(['index' => $name]);
    }

    public function indexExists($name)
    {
        return $this->client->indices()->exists(['index' => $name]);
    }

    public function createIndex()
    {
        $params = [
            'index' => 'vinci',
            'body' => [
                'mappings' => [
                    'product' => [
                        'properties' => [
                            'id' => [
                                'type' => 'integer'
                            ],
                            'sku' => [
                                'type' => 'integer'
                            ],
                            'title' => [
                                'type' => 'string'
                            ],
                            'description' => [
                                'type' => 'string'
                            ],
                            'price' => [
                                'type' => 'double'
                            ],
                            'bottle_size' => [
                                'type' => 'string'
                            ],
                            'country' => [
                                'properties' => [
                                    'id' => [
                                        'type' => 'integer'
                                    ],
                                    'title' => [
                                        'type' => 'string',
                                        'index' => 'not_analyzed'
                                    ]
                                ],
                            ],
                            'region' => [
                                'properties' => [
                                    'id' => [
                                        'type' => 'integer'
                                    ],
                                    'title' => [
                                        'type' => 'string',
                                        'index' => 'not_analyzed'
                                    ]
                                ],
                            ],
                            'producer' => [
                                'properties' => [
                                    'id' => [
                                        'type' => 'integer'
                                    ],
                                    'title' => [
                                        'type' => 'string',
                                        'index' => 'not_analyzed'
                                    ]
                                ],
                            ],
                        ]
                    ]
                ]
            ]
        ];

        $this->client->indices()->create($params);
    }

    public function indexAllProducts()
    {

        if ($this->indexExists('vinci')) {
            $this->deleteIndex('vinci');
            $this->createIndex();
        }

        $query = $this->productRepository->getProductsForIndexing();

        //$iterable = $query->iterate();

        foreach ($query as $item) {

            $product = $item;

            $params['body'][] = [
                'index' => [
                    '_index' => 'vinci',
                    '_type' => 'product',
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

                if ($product->hasProductType()) {
                    $productType = $product->getProductType();

                    $data['product_type'] = [
                        'id' => $productType->getId(),
                        'title' => $productType->getName()
                    ];
                }

                if ($product->hasAttributeByName('bottle_size')) {
                    $data['bottle_size'] = $product->getAttribute('bottle_size');
                }

                /*if ($product->hasAttributes()) {
                    $attributes = $product->getAttributes();

                    foreach ($attributes as $attribute) {
                        if (! empty($attribute->getValue())) {
                            $data[$attribute->getAttribute()->getCode()] = $attribute->getValue();
                        }
                    }
                }*/

            }

            $params['body'][] = $data;
        }

        return $this->client->bulk($params);
    }


}
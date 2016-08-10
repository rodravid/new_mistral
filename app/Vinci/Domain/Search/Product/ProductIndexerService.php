<?php

namespace Vinci\Domain\Search\Product;

use Elasticsearch\Client;
use Vinci\Domain\Showcase\ShowcaseRepository;
use Vinci\Domain\Showcase\StaticShowcases\StaticShowcasesProvider;

class ProductIndexerService
{

    private $client;

    private $productRepository;

    private $showcaseRepository;

    private $staticShowcasesProvider;

    public function __construct(
        Client $client,
        ProductRepositoryInterface $productRepository,
        ShowcaseRepository $showcaseRepository,
        StaticShowcasesProvider $staticShowcasesProvider
    ) {
        $this->client = $client;
        $this->productRepository = $productRepository;
        $this->showcaseRepository = $showcaseRepository;
        $this->staticShowcasesProvider = $staticShowcasesProvider;
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
                'settings' => [
                    'index' => [
                        'analysis' => [
                            'analyzer' => [
                                'analyzer_keyword' => [
                                    'tokenizer' => 'standard',
                                    'filter' => 'lowercase'
                                ]
                            ]
                        ]
                    ]
                ],
                'mappings' => [
                    'product' => [
                        'properties' => [
                            'id' => [
                                'type' => 'integer'
                            ],
                            'sku' => [
                                'type' => 'string'
                            ],
                            'title' => [
                                'type' => 'string',
                                'analyzer' => 'analyzer_keyword',
                                'fields' => [
                                    'raw' => [
                                        'type' => 'string',
                                        'index' => 'not_analyzed'
                                    ]
                                ]
                            ],
                            'description' => [
                                'type' => 'string',
                                'analyzer' => 'analyzer_keyword'
                            ],
                            'short_description' => [
                                'type' => 'string',
                                'analyzer' => 'analyzer_keyword'
                            ],
                            'price' => [
                                'type' => 'double'
                            ],
                            'available' => [
                                'type' => 'integer'
                            ],
                            'bottle_size' => [
                                'type' => 'string',
                                'analyzer' => 'analyzer_keyword',
                                'fields' => [
                                    'raw' => [
                                        'type' => 'string',
                                        'index' => 'not_analyzed'
                                    ]
                                ]
                            ],
                            'country' => [
                                'properties' => [
                                    'id' => [
                                        'type' => 'integer'
                                    ],
                                    'title' => [
                                        'type' => 'string',
                                        'analyzer' => 'analyzer_keyword',
                                        'fields' => [
                                            'raw' => [
                                                'type' => 'string',
                                                'index' => 'not_analyzed'
                                            ]
                                        ]
                                    ],
                                ],
                            ],
                            'region' => [
                                'properties' => [
                                    'id' => [
                                        'type' => 'integer'
                                    ],
                                    'title' => [
                                        'type' => 'string',
                                        'analyzer' => 'analyzer_keyword',
                                        'fields' => [
                                            'raw' => [
                                                'type' => 'string',
                                                'index' => 'not_analyzed'
                                            ]
                                        ]
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
                                        'analyzer' => 'analyzer_keyword',
                                        'fields' => [
                                            'raw' => [
                                                'type' => 'string',
                                                'index' => 'not_analyzed'
                                            ]
                                        ]
                                    ]
                                ],
                            ],
                            'product_type' => [
                                'properties' => [
                                    'id' => [
                                        'type' => 'integer'
                                    ],
                                    'title' => [
                                        'type' => 'string',
                                        'analyzer' => 'analyzer_keyword',
                                        'fields' => [
                                            'raw' => [
                                                'type' => 'string',
                                                'index' => 'not_analyzed'
                                            ]
                                        ]
                                    ]
                                ],
                            ],
                            'grapes' => [
                                'properties' => [
                                    'id' => [
                                        'type' => 'integer'
                                    ],
                                    'title' => [
                                        'type' => 'string',
                                        'analyzer' => 'analyzer_keyword',
                                        'fields' => [
                                            'raw' => [
                                                'type' => 'string',
                                                'index' => 'not_analyzed'
                                            ]
                                        ]
                                    ],
                                    'weight' => [
                                        'type' => 'double'
                                    ]
                                ],
                            ],
                            'suggest' => [
                                'type' => 'completion',
                                'index_analyzer' => 'simple',
                                'search_analyzer' => 'simple',
                                'payloads' => true,
                            ]
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
                'title' => $product->present()->title,
                'description' => $product->getDescription(),
                'short_description' => $product->getShortDescription(),
                'price' => $product->getSalePrice(),
                'available' => (int) $product->isAvailable()
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

            foreach ($this->showcaseRepository->getByProduct($product) as $showcase) {
                $data['keywords'] .= $showcase->getKeywords();

                $data['showcases'][] = [
                    'id' => $showcase->getId(),
                    'title' => $showcase->getTitle(),
                    'keywords' => $showcase->getKeywords()
                ];

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
                    if (! empty($attribute->getValue())) {

                        if ($attribute->getAttribute()->getCode() == 'bottle_size' && ! contains_numbers($attribute->getValue())) {
                            continue;
                        }

                        $data[$attribute->getAttribute()->getCode()] = $attribute->getValue();
                    }
                }
            }

            $params['body'][] = $data;
        }

        return $this->client->bulk($params);
    }


}
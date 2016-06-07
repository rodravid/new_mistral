<?php

namespace Vinci\Domain\Search\Product;

use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Search\Filter\FilterFactory;
use Vinci\Domain\Search\Product\Presenters\ProductSearchResultPresenter;
use Vinci\Domain\Search\Product\Result\ProductSearchResult;
use Vinci\Domain\Search\SearchService;
use Elasticsearch\ClientBuilder;
use Illuminate\Contracts\Config\Repository;

class ProductSearchService extends SearchService
{

    protected $productRepository;

    protected $presenter;

    public function __construct(
        ClientBuilder $builder,
        Repository $config,
        FilterFactory $filterFactory,
        ProductRepository $productRepository,
        Presenter $presenter
    ) {
        parent::__construct($builder, $config, $filterFactory);

        $this->productRepository = $productRepository;
        $this->presenter = $presenter;

        $this->filterFactory->setTitles($this->getFiltersTitles());
    }

    public function search($keyword, $limit = 10, $start = 0)
    {
        $params = $this->getSearchParams($keyword, $limit, $start);

        $result = $this->client->search($params);

        //dd($result);

        $result['keyword'] = $keyword;
        $result['limit'] = $limit;
        $result['start'] = $start;

        $result = $this->presenter->model($this->parseResult($result), ProductSearchResultPresenter::class);

        return $result;
    }

    protected function parseItems(array $result)
    {
        $hits = $result['hits'];

        $productsIds = array_column($hits['hits'], '_id');

        $products = $this->productRepository->getProductsById($productsIds);

        $products = $this->presenter->collection($products, ProductPresenter::class);

        return $products;
    }

    protected function getNewResultClassInstance()
    {
        return new ProductSearchResult;
    }

    protected function getFiltersTitles()
    {
        return [
            'countries' => 'Países',
            'regions' => 'Regiões',
            'producers' => 'Produtores'
        ];
    }

    private function getSearchParams($keyword, $limit, $start)
    {
        return [
            'index' => 'vinci',
            'type' => 'product',
            'from' => $start,
            'size' => $limit,
            'body' => [
//                'filter' => [
//                    'bool' => [
//                        'should' => [
//                            'term' => [
//                                'country.title' => 'California'
//                            ]
//                        ]
//                    ]
//                ],
//                'query' => [
//                    'bool' => [
//                        'should' => [
//                            ['term' => ['title' => $keyword]],
//                            ['term' => ['country.title' => $keyword]],
//                            ['term' => ['region.title' => $keyword]],
//                            ['term' => ['region.title' => $keyword]]
//                        ],
//                        'filter' => [
//                            'term' => [
//                                'country.title' => 'Portugal'
//                            ]
//                        ]
//                    ],
//                ],
//                  'filter' => [
//                      'bool' => [
//                          'must' => [
//                              'multi_match' => [
//                                  'query' => $keyword,
//                                  'fields' => ['title', 'country.title', 'region.title', 'producer.title', 'product_type.title', 'safra', 'bottle_size']
//                              ]
//                          ],
//                          'filter' => [
//                              'term' => [
//                                  'country.title' => 'California'
//                              ]
//                          ]
//                      ]
//                  ],
                'query' => [

                    'filtered' => [
                        'filter' => [
                            'bool' => [
                                'should' => [
                                    ['term' => ['title' => $keyword]],
                                    ['term' => ['country.title' => $keyword]],
                                    ['term' => ['region.title' => $keyword]],
                                    ['term' => ['producer.title' => $keyword]]
                                ],
//                                'must' => [
//                                    [
//                                        'terms' => [
//                                            'country.title' => ['Itália'],
//                                        ],
//                                    ],
////                                    [
////                                        'terms' => [
////                                            'region.title' => ['California']
////                                        ],
////                                    ]
//                                ]
                            ],
                        ]
                    ],


//                    'multi_match' => [
//                        'query' => $keyword,
//                        'fields' => ['title', 'country.title', 'region.title', 'producer.title', 'product_type.title', 'safra', 'bottle_size']
//                    ]
                ],

                'post_filter' => [
                    'bool' => [
                        'should' => [
                            ['terms' => ['country.title' => ['Brasil', 'Chile']]],
                            //['terms' => ['region.title' => ['Alenquer']]],
                        ]
                        //'country.title' => ['Brasil', 'Chile'],
                        //['region.title' => ['Rio Grande do Sul']]
                    ]
                ],

                'aggs' => [
                    'countries' => [
                        'terms' => [
                            "field" => 'country.title',
                            'size' => 20
                        ]
                    ],
                    'regions' => [
//                        'filters' => [
//                            'filters' => [
//                                ['term' => ['region.title' => 'California']]
//                            ],
//                        ],
                        'terms' => [
                            "field" => 'region.title'
                        ]
                    ],
                    'producers' => [
                        'terms' => [
                            "field" => 'producer.title'
                        ]
                    ],
                ],
            ],
            'sort' => ['price:desc']
        ];
    }

}
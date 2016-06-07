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

    public function search($keyword = null, array $filters = [], $limit = 10, $start = 0)
    {
        $params = $this->getSearchParams($keyword, $filters, $limit, $start);

        $result = $this->client->search($params);

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
            'producers' => 'Produtores',
            'pais' => 'Países',
            'regiao' => 'Regiões',
            'produtor' => 'Produtores',
        ];
    }

    private function getSearchParams($keyword = null, array $filters = [], $limit = 10, $start = 0)
    {
        $params = [
            'index' => 'vinci',
            'type' => 'product',
            'from' => $start,
            'size' => $limit,
            'body' => [
                'aggs' => [
                    'pais' => [
                        'terms' => [
                            'field' => 'country.title',
                            'size' => 20
                        ]
                    ],
                    'regiao' => [
                        'terms' => [
                            'field' => 'region.title',
                            'size' => 20
                        ]
                    ],
                    'produtor' => [
                        'terms' => [
                            'field' => 'producer.title',
                            'size' => 20
                        ]
                    ],
                ],
            ],
            'sort' => ['price:desc']
        ];

        if (! empty($keyword)) {

            $params['body']['query'] = [
                'filtered' => [
                    'filter' => [
                        'bool' => [
                            'should' => [
                                ['term' => ['title' => $keyword]],
                                ['term' => ['country.title' => $keyword]],
                                ['term' => ['region.title' => $keyword]],
                                ['term' => ['producer.title' => $keyword]]
                            ],
//                            'must' => [
//                                [
//                                    'terms' => [
//                                        'country.title' => ['Itália'],
//                                    ],
//                                ],
//                            ]
                        ],
                    ]
                ],
            ];

        }

        if (! empty($filters)) {

            if (isset($filters['post']) && ! empty($filters['post'])) {

                if (! empty($countries = array_get($filters, 'post.pais'))) {
                    $this->addPostFilter($params, 'country.title', $countries);
                }

                if (! empty($regions = array_get($filters, 'post.regiao'))) {
                    $this->addPostFilter($params, 'region.title', $regions);
                }

                if (! empty($producers = array_get($filters, 'post.produtor'))) {
                    $this->addPostFilter($params, 'producer.title', $producers);
                }

            }

            if (isset($filters['filters']) && ! empty($filters['filters'])) {

                if (! empty($countries = array_get($filters, 'filters.pais'))) {
                    $this->addFilter($params, 'country.title', $countries);
                }

                if (! empty($regions = array_get($filters, 'filters.regiao'))) {
                    $this->addFilter($params, 'region.title', $regions);
                }

                if (! empty($producers = array_get($filters, 'filters.produtor'))) {
                    $this->addFilter($params, 'producer.title', $producers);
                }

            }

        }

        return $params;
    }

    protected function addPostFilter(array &$params, $column, array $values)
    {
        $search = [
            'body' => [
                'post_filter' => [
                    'bool' => [
                        'should' => [
                            ['terms' => [$column => $values]],
                        ]
                    ]
                ]
            ]
        ];

        $params = array_merge_recursive($params, $search);
    }

    protected function addFilter(array &$params, $column, array $values)
    {
        $search = [
            'body' => [
                'query' => [
                    'filtered' => [
                        'filter' => [
                            'bool' => [
                                'must' => [
                                    ['terms' => [$column => $values]],
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $params = array_merge_recursive($params, $search);
    }

}
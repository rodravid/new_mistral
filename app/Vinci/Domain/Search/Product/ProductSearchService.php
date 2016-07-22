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
use Vinci\Domain\Search\Suggester\SuggesterFactory;

class ProductSearchService extends SearchService
{

    protected $productRepository;

    protected $presenter;

    public function __construct(
        ClientBuilder $builder,
        Repository $config,
        FilterFactory $filterFactory,
        SuggesterFactory $suggesterFactory,
        ProductRepository $productRepository,
        Presenter $presenter
    ) {
        parent::__construct($builder, $config, $filterFactory, $suggesterFactory);

        $this->productRepository = $productRepository;
        $this->presenter = $presenter;

        $this->filterFactory->setTitles($this->getFiltersTitles());
    }

    public function search($keyword = null, array $filters = [], $limit = 10, $start = 0, $sort = 1)
    {
        $params = $this->getSearchParams($keyword, $filters, $limit, $start, $sort);

        $result = $this->client->search($params);

        $result['keyword'] = $keyword;
        $result['limit'] = $limit;
        $result['start'] = $start;
        $result['sort'] = $sort;

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
            'preco' => 'Preço',
        ];
    }

    private function getSearchParams($keyword = null, array $filters = [], $limit = 10, $start = 0, $sort = 1)
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
                    'preco' => [
                        'range' => [
                            'field' => 'price',
                            'ranges' => [
                                ['to' => 60, 'key' => '*-60'],
                                ['from' => 60, 'to' => 100, 'key' => '60-100'],
                                ['from' => 100, 'to' => 170, 'key' => '100-170'],
                                ['from' => 170, 'to' => 270, 'key' => '170-270'],
                                ['from' => 270, 'to' => 500, 'key' => '270-500'],
                                ['from' => 500, 'key' => '500-*']
                            ]
                        ]
                    ]
                ],
            ],
           'sort' => $this->getSort($sort)
        ];

        if (! empty($keyword)) {

            $params['body']['query'] = [
                'bool' => [
                    'should' => [
                        ['term' => ['_id' => $keyword]],
                        ['term' => ['sku' => intval($keyword)]],
                        ['match' => ['title' => $keyword]],
                        ['match' => ['keywords' => $keyword]],
                        ['match' => ['country.title' => $keyword]],
                        ['match' => ['region.title' => $keyword]],
                        ['match' => ['producer.title' => $keyword]],
                        ['fuzzy' =>
                            [
                                'title' => [
                                    'value' => $keyword,
                                    'fuzziness' => 2
                                ]
                            ]
                        ]
                    ]
                ]
            ];

            $params['body']['suggest'] = [
                'title-suggester' => [
                    'text' => $keyword,
                    'completion' => [
                        'field' => 'suggest',
                        'fuzzy' => [
                            'fuzziness' => 2
                        ]
                    ]
                ]
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

                if (! empty($preco = array_get($filters, 'post.preco'))) {
                    $this->addPostFilterPrice($params, 'price', $preco);
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

                if (! empty($showcases = array_get($filters, 'filters.showcase'))) {
                    $this->addFilter($params, 'showcases.id', $showcases);
                }

            }

        }

        return $params;
    }

    protected function getSort($order)
    {

        switch ($order) {

            case 1:
                return ['_score'];
                break;

            case 2:
                return ['price:asc'];
                break;

            case 3:
                return ['price:desc'];
                break;

            case 4:
                return ['title.raw:asc'];
                break;

            case 5:
                return ['title.raw:desc'];
                break;

        }

        return ['_score'];
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

    protected function addPostFilterPrice(array &$params, $column, array $values)
    {
        $val = $values[0];

        $price = explode('-', $val);

        $p = [];

        if ($price[0] !== '*') {
            $p['gte'] = $price[0];
        }

        if ($price[1] !== '*') {
            $p['lte'] = $price[1];
        }

        $prices[] = [
            $column => $p
        ];

        $search = [
            'body' => [
                'post_filter' => [
                    'bool' => [
                        'should' => [
                            ['range' => [$column => $p]]
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
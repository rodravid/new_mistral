<?php

namespace Vinci\Domain\Search\Product;

use Illuminate\Support\Str;
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

    protected $resultClass = ProductSearchResult::class;

    protected $aggsMapping = [
        'pais' => [
            'title' => 'País',
            'field' => 'country.title.raw',
            'type' => 'term',
            'size' => 20,
            'filtered_by' => ['regiao', 'produtor', 'tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco', 'showcase']
        ],
        'regiao' => [
            'title' => 'Região',
            'field' => 'region.title.raw',
            'type' => 'term',
            'size' => 20,
            'filtered_by' => ['pais', 'regiao', 'produtor', 'tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco', 'showcase']
        ],
        'produtor' => [
            'title' => 'Produtor',
            'field' => 'producer.title.raw',
            'type' => 'term',
            'size' => 20,
            'filtered_by' => ['pais', 'regiao', 'tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco', 'showcase']
        ],
        'tipo-de-uva' => [
            'title' => 'Tipo de uva',
            'field' => 'grapes.title.raw',
            'type' => 'term',
            'size' => 20,
            'filtered_by' => ['pais', 'regiao', 'produtor', 'tipo-de-vinho', 'tamanho', 'preco', 'showcase']
        ],
        'tipo-de-vinho' => [
            'title' => 'Tipo de vinho',
            'field' => 'product_type.title.raw',
            'type' => 'term',
            'size' => 20,
            'filtered_by' => ['pais', 'regiao', 'produtor', 'tipo-de-uva', 'tamanho', 'preco', 'showcase']
        ],
        'tamanho' => [
            'title' => 'Tamanho',
            'field' => 'bottle_size.raw',
            'type' => 'term',
            'size' => 20,
            'filtered_by' => ['pais', 'regiao', 'produtor', 'tipo-de-uva', 'tipo-de-vinho', 'preco', 'showcase']
        ],
        'preco' => [
            'title' => 'Preço',
            'field' => 'price',
            'type' => 'range',
            'size' => 20,
            'filtered_by' => ['pais', 'regiao', 'produtor', 'tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'showcase']
        ],
        'showcase' => [
            'title' => 'Vitrine',
            'field' => 'showcases.id',
            'type' => 'term'
        ],
    ];

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
        $keyword = Str::lower($keyword);

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
                        'filter' => $this->makeAggFilter('pais', $filters),
                        'aggs' => [
                            'pais' => [
                                'terms' => [
                                    'field' => 'country.title.raw',
                                    'size' => 20
                                ]
                            ],
                        ]
                    ],
                    'regiao' => [
                        'filter' => $this->makeAggFilter('regiao', $filters),
                        'aggs' => [
                            'regiao' => [
                                'terms' => [
                                    'field' => 'region.title.raw',
                                    'size' => 20
                                ]
                            ]
                        ]
                    ],
                    'produtor' => [
                        'filter' => $this->makeAggFilter('produtor', $filters),
                        'aggs' => [
                            'produtor' => [
                                'terms' => [
                                    'field' => 'producer.title.raw',
                                    'size' => 20
                                ]
                            ]
                        ]
                    ],
                    'preco' => [
                        'filter' => $this->makeAggFilter('preco', $filters),
                        'aggs' => [
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
                            ],
                        ],
                    ],
                    'tipo-de-uva' => [
                        'filter' => $this->makeAggFilter('tipo-de-uva', $filters),
                        'aggs' => [
                            'tipo-de-uva' => [
                                'terms' => [
                                    'field' => 'grapes.title.raw',
                                    'size' => 20
                                ]
                            ]
                        ]
                    ],
                    'tipo-de-vinho' => [
                        'filter' => $this->makeAggFilter('tipo-de-vinho', $filters),
                        'aggs' => [
                            'tipo-de-vinho' => [
                                'terms' => [
                                    'field' => 'product_type.title.raw',
                                    'size' => 20
                                ]
                            ]
                        ],
                    ],
                    'tamanho' => [
                        'filter' => $this->makeAggFilter('tamanho', $filters),
                        'aggs' => [
                            'tamanho' => [
                                'terms' => [
                                    'field' => 'bottle_size.raw',
                                    'size' => 20
                                ]
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
                        ['wildcard' => ['title' => $keyword . '*']],
                        ['match' => ['keywords' => $keyword]],
                        ['match' => ['short_description' => $keyword]],
                        ['match' => ['country.title' => $keyword]],
                        ['match' => ['region.title' => $keyword]],
                        ['match' => ['producer.title' => $keyword]],
                        ['match' => ['product_type.title' => $keyword]],
                        ['match' => ['grapes.title' => $keyword]],
                        ['fuzzy' =>
                            [
                                'title' => [
                                    'value' => $keyword,
                                    'fuzziness' => 1
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

            if (! empty($countries = array_get($filters, 'pais'))) {
                $this->addFilter($params, 'country.title.raw', $countries);
            }

            if (! empty($regions = array_get($filters, 'regiao'))) {
                $this->addFilter($params, 'region.title.raw', $regions);
            }

            if (! empty($producers = array_get($filters, 'produtor'))) {
                $this->addFilter($params, 'producer.title.raw', $producers);
            }

            if (! empty($grapes = array_get($filters, 'tipo-de-uva'))) {
                $this->addFilter($params, 'grapes.title.raw', $grapes);
            }

            if (! empty($types = array_get($filters, 'tipo-de-vinho'))) {
                $this->addFilter($params, 'product_type.title.raw', $types);
            }

            if (! empty($size = array_get($filters, 'tamanho'))) {
                $this->addFilter($params, 'bottle_size.raw', $size);
            }

            if (! empty($price = array_get($filters, 'preco'))) {
                $this->addFilterRange($params, 'price', $price);
            }

            if (! empty($showcases = array_get($filters, 'showcase'))) {
                $this->addFilter($params, 'showcases.id', $showcases);
            }

        }

        return $params;
    }

    protected function getSort($order)
    {
        switch ($order) {
            case 1: return ['_score']; break;
            case 2: return ['price:asc']; break;
            case 3: return ['price:desc']; break;
            case 4: return ['title.raw:asc']; break;
            case 5: return ['title.raw:desc']; break;
        }

        return ['_score'];
    }

}
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
                'query' => [
                    'multi_match' => [
                        'query' => $keyword,
                        'fields' => ['title', 'country.title', 'region.title', 'producer.title', 'product_type.title', 'safra', 'bottle_size']
                    ]
                ],
                'aggs' => [
                    'countries' => [
                        'terms' => [
                            "field" => 'country.title'
                        ]
                    ],
                    'regions' => [
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
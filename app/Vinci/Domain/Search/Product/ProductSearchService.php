<?php

namespace Vinci\Domain\Search\Product;

use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\Product\Repositories\ProductRepository;
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
        ProductRepository $productRepository,
        Presenter $presenter
    ) {
        parent::__construct($builder, $config);

        $this->productRepository = $productRepository;
        $this->presenter = $presenter;
    }

    public function search($keyword, $limit = 10, $start = 0)
    {
        $params = [
            'index' => 'vinci',
            'type' => 'products',
            'from' => $start,
            'size' => $limit,
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $keyword,
                        'fields' => ['title', 'country.title', 'region.title', 'producer.title', 'product_type.title', 'safra', 'bottle_size']
                    ]
                ]
            ],
            'sort' => ['price:desc']
        ];

        $result = $this->client->search($params);

        $result['keyword'] = $keyword;

        return $this->parseResult($result);
    }

    public function parseResult(array $result)
    {
        $hits = $result['hits'];

        $searchResult = new ProductSearchResult;

        $searchResult->setTerm($result['keyword']);

        if ($hits['total'] > 0) {

            $productsIds = array_column($hits['hits'], '_id');

            $products = $this->productRepository->getProductsById($productsIds);

            $products = $this->presenter->collection($products, ProductPresenter::class);

            $searchResult
                ->setTotal($hits['total'])
                ->setItems($products);

        }

        return $searchResult;
    }

}
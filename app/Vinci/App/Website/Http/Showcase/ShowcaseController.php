<?php

namespace Vinci\App\Website\Http\Showcase;

use Cache;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use \View;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\App\Website\Http\Search\SearchController;
use Vinci\App\Website\Http\Showcase\Presenters\ShowcasePresenter;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Search\Product\ProductSearchService;
use Vinci\Domain\Showcase\ShowcaseRepository;

class ShowcaseController extends SearchController
{

    private $showcaseRepository;

    private $productRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProductSearchService $searchService,
        ShowcaseRepository $showcaseRepository,
        ProductRepository $productRepository
    ) {
        parent::__construct($em, $searchService);

        $this->showcaseRepository = $showcaseRepository;
        $this->productRepository = $productRepository;
    }

    public function show($slug, Request $request)
    {
        $showcase = $this->getShowcase($slug);

        $filters = [
            'filters' => [
                'showcase' => [$showcase->getId()]
            ]
        ];

        $result = $this->search($request, $filters);

        return $this->view('showcase.index', compact('showcase', 'result'));
    }

    protected function getShowcase($slug)
    {
        $showcase = $this->showcaseRepository->getOneBySlug($slug);

        $showcase = $this->presenter->model($showcase, ShowcasePresenter::class);

        return $showcase;
    }

    public function getProducts($showcase, Request $request)
    {
        $limit = $request->get('limit', 1);
        $page = $request->get('page', 1);
        $cacheKey = $this->getCacheKey([$showcase, $limit, $page]);

        return Cache::remember($cacheKey, 1, function() use ($showcase, $limit, $page) {

            $products = $this->productRepository->getProductsByShowcase($showcase, $limit, $page);

            $products = $this->presenter->paginator($products, ProductPresenter::class);

            return View::renderEach('website::layouts.partials.product.cards.default', $products, 'product');

        });
    }

    protected function getCacheKey(array $keys)
    {
        return vsprintf('showcase-products-%s-%s-%s', $keys);
    }

    protected function getSearchUrlPath($request)
    {
        return $request->get('slug');
    }

}
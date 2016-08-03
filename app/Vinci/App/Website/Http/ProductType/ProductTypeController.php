<?php

namespace Vinci\App\Website\Http\ProductType;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\ProductType\ProductTypeRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class ProductTypeController extends BaseTaxonomyController
{

    private $productTypeRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProductTypeRepository $productTypeRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->productTypeRepository = $productTypeRepository;
    }

    public function show($slug, Request $request)
    {
        $productType = $this->getProductType($slug);

        $filters = [
            'tipo-de-vinho' => [$productType->getName()]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['pais', 'regiao', 'produtor', 'tipo-de-uva', 'tamanho', 'preco']);

        return $this->view('product-type.index', compact('productType', 'result'));
    }

    protected function getProductType($slug)
    {
        $productType = $this->productTypeRepository->getOneBySlug($slug);

        $productType = $this->presenter->model($productType, ProductTypePresenter::class);

        return $productType;
    }

}
<?php

namespace Vinci\App\Website\Http\ProductType;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Common\TaxonomyCollection;
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

    public function index(Request $request)
    {
        $productsType = new TaxonomyCollection($this->productTypeRepository->getAll());

        $productsType = $productsType->filter(function ($productType) {
            return ! in_array($productType->getName(), ['Acessório', 'Embalagem', 'Kits', 'Outros']);
        });

        $pageDescription = 'Todos os tipos de vinho Tinto, 
                            Branco Seco, Rosado, Espumante, 
                            Branco Doce, Vinho do Porto, Tinto Doce, 
                            Madeira, Licor e outros. Encontre o seu favorito!';

        return $this->view('layouts.pages.list')
                    ->with([
                        'metaTitle' => 'Encontre o tipo de vinho ideal para cada ocasião - Vinci',
                        'metaDescription' => $pageDescription,
                        'resources' => $productsType,
                        'resourceType' => 'product-type',
                        'pageTitle' => 'Tipos de vinho',
                        'pageDescription' => $pageDescription,
                        'template' => 'template4',
                        'imageTitle' => 'bg-tipo-vinho.jpg'
                    ]);
    }

    protected function getProductType($slug)
    {
        $productType = $this->productTypeRepository->getOneBySlug($slug);

        $productType = $this->presenter->model($productType, ProductTypePresenter::class);

        return $productType;
    }

}
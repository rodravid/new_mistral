<?php

namespace Vinci\App\Website\Http\Showcase;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use \View;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\Product\Repositories\ProductRepository;

class ShowcaseController extends Controller
{

    private $productRepository;

    public function __construct(EntityManagerInterface $em, ProductRepository $productRepository)
    {
        parent::__construct($em);

        $this->productRepository = $productRepository;
    }

    public function getProducts($showcase, Request $request)
    {
        $limit = $request->get('limit', 1);
        $page = $request->get('page', 1);

        $products = $this->productRepository->getProductsByShowcase($showcase, $limit, $page);

        $products = $this->presenter->paginator($products, ProductPresenter::class);

        return View::renderEach('website::layouts.partials.product.cards.default', $products, 'product');
    }

}
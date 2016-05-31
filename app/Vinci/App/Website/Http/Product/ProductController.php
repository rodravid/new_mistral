<?php

namespace Vinci\App\Website\Http\Product;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\ProductType;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Wine\Wine;

class ProductController extends Controller
{

    private $productRepository;

    public function __construct(EntityManagerInterface $em, ProductRepository $productRepository)
    {
        parent::__construct($em);

        $this->productRepository = $productRepository;
    }

    public function show($type, $slug)
    {
        $type = $this->parseProductType($type);
        $slug = $this->parseProductSlug($slug);

        $product = $this->productRepository->getOneByTypeAndSlug($type, $slug);

        $product = $this->presenter->model($product, ProductPresenter::class);

        return $this->view('product.index', compact('product'));
    }

    private function parseProductType($type)
    {
        switch($type) {
            case 'vinho':
                return Wine::class;
                break;

            case 'acessorios';
                return Product::class;
                break;
        }

        abort(404);
    }

    private function parseProductSlug($slug)
    {
        return trim($slug);
    }

}
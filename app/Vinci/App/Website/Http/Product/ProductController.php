<?php

namespace Vinci\App\Website\Http\Product;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Request;
use Response;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Services\FavoriteService;
use Vinci\Domain\Product\Wine\Wine;

class ProductController extends Controller
{

    private $productRepository;

    private $favoriteService;

    public function __construct(EntityManagerInterface $em, ProductRepository $productRepository, FavoriteService $favoriteService)
    {
        parent::__construct($em);

        $this->productRepository = $productRepository;
        $this->favoriteService = $favoriteService;
    }

    public function show($type, $slug)
    {
        $type = $this->parseProductType($type);
        $slug = $this->parseProductSlug($slug);

        $product = $this->productRepository->getOneByTypeAndSlug($type, $slug);

        $product = $this->presenter->model($product, ProductPresenter::class);

        return $this->view('product.index', compact('product'));
    }

    public function favorite($product, Request $request)
    {

        try {

            $toggle = $request->get('toggle', true);

            $product = $this->productRepository->getOneById($product);

            $this->favoriteService->toggle($product, $this->user, $toggle);

            return Response::json([
                'message' => sprintf('O produto foi %s sua lista de favoritos.', $toggle ? 'adicionado à' : 'removido da')
            ]);

        } catch (Exception $e) {

            return Response::json([
                'message' => 'Não foi possível adicioanr o produto a sua lista de favoritos. Tente novamente mais tarde.'
            ], 500);
        }

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
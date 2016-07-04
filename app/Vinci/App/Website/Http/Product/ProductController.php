<?php

namespace Vinci\App\Website\Http\Product;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Response;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\ProductNotify\Services\ProductNotifyService;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Services\FavoriteService;
use Vinci\Domain\Product\Services\ProductManagementService;
use Vinci\Domain\Product\Wine\Wine;
use Vinci\Domain\Recomendations\Products\Service\ProductRecommendedService;

class ProductController extends Controller
{

    private $productRepository;

    private $favoriteService;

    private $productService;

    private $productNotifyService;

    private $recommendedService;

    public function __construct(
        EntityManagerInterface $em,
        ProductRepository $productRepository,
        FavoriteService $favoriteService,
        ProductManagementService $productService,
        ProductNotifyService $productNotifyService,
        ProductRecommendedService $recommendedService
    ) {
        parent::__construct($em);

        $this->productRepository = $productRepository;
        $this->favoriteService = $favoriteService;
        $this->productService = $productService;
        $this->productNotifyService = $productNotifyService;
        $this->recommendedService = $recommendedService;
    }

    public function show($type, $slug)
    {
        $type = $this->parseProductType($type);
        $slug = $this->parseProductSlug($slug);

        $product = $this->productRepository->getOneByTypeAndSlug($type, $slug);
        $productsRecommended = $this->recommendedService->getRecommendedByProduct($product);
        $product = $this->presenter->model($product, ProductPresenter::class);

        $templates = [
            0 => 'template2',
            1 => 'template4',
            2 => 'template7',
            3 => 'template1',
        ];

        return $this->view('product.index', compact('product', 'productsRecommended', 'templates'));
    }

    public function favorite($product, Request $request)
    {

        try {

            $toggle = $request->get('toggle', true);

            $product = $this->productRepository->getOneById($product);

            $this->favoriteService->toggle($product, $this->user, $toggle);

            return Response::json([
                'message' => sprintf('O produto foi %s sua lista de favoritos.', $toggle ? 'adicionado à' : 'removido da'),
            ]);

        } catch (Exception $e) {

            return Response::json([
                'message' => 'Não foi possível adicionar o produto à sua lista de favoritos. Tente novamente mais tarde.',
            ], 500);
        }

    }

    private function parseProductType($type)
    {
        switch ($type) {
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

    public function registerNotify(Request $request)
    {
        try {

            $data = $request->all();

            $this->productNotifyService->registerNotify($data);

            Flash::success('Seu contato foi cadastrado com succeso! Avisaremos assim que o produto estiver disponível');

            return Redirect::back();

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error('Ops! Não foi possível adicionar seu contato para notificação!');

            return Redirect::back()->withInput();
        }
    }

}

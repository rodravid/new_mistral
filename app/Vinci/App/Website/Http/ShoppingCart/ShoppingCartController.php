<?php

namespace Vinci\App\Website\Http\ShoppingCart;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Request;
use Response;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\ShoppingCart\Transformers\ShoppingCartTransformer;
use Vinci\Domain\Product\Repositories\ProductVariantRepository;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;

class ShoppingCartController extends Controller
{

    private $cartService;

    private $variantRepository;

    public function __construct(EntityManagerInterface $em, ShoppingCartService $cartService, ProductVariantRepository $variantRepository)
    {
        parent::__construct($em);

        $this->cartService = $cartService;
        $this->variantRepository = $variantRepository;
    }

    public function index(Request $request)
    {
        return $this->view('cart.index');
    }

    public function getItems()
    {
        $cart = fractal()
            ->item($this->cartService->getCart())
            ->transformWith(new ShoppingCartTransformer());

        return Response::json($cart->toArray());
    }

    public function add(Request $request)
    {
        try {

            $variant = $request->get('variant');
            $quantity = $request->get('quantity', 1);

            $this->cartService->addItem($variant, $quantity);

            return Response::json([
                'success' => true,
                'message' => trans('cart.item_added')
            ]);

        } catch (Exception $e) {

            throw $e;

            return Response::json([
                'success' => false,
                'message' => trans('cart.item_add_failed')
            ]);

        }
    }

    public function syncQuantity(Request $request)
    {
        try {

            $item = $request->get('item');
            $quantity = $request->get('quantity', 1);

            $this->cartService->syncQuantity($item, $quantity);

            return Response::json([
                'success' => true,
                'message' => trans('cart.item_quantity_synced')
            ]);

        } catch (Exception $e) {

            throw $e;

            return Response::json([
                'success' => false,
                'message' => trans('cart.item_add_failed')
            ]);

        }
    }

}
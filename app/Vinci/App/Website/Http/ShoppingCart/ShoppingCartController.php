<?php

namespace Vinci\App\Website\Http\ShoppingCart;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Request;
use Response;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\ShoppingCart\Transformers\ShoppingCartTransformer;
use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Product\Repositories\ProductVariantRepository;
use Vinci\Domain\Shipping\Services\ShippingService;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class ShoppingCartController extends Controller
{

    private $cartService;

    private $shippingService;

    private $variantRepository;

    public function __construct(
        EntityManagerInterface $em,
        ShoppingCartService $cartService,
        ShippingService $shippingService,
        ProductVariantRepository $variantRepository
    ) {
        parent::__construct($em);

        $this->cartService = $cartService;
        $this->shippingService = $shippingService;
        $this->variantRepository = $variantRepository;
    }

    public function index()
    {
        return $this->view('cart.index');
    }

    public function getItems(Request $request)
    {
        $shoppingCart = $this->cartService->getCart();

        if (! empty($request->get('postal_code'))) {

            $shipping = $this->getShipping($request->get('postal_code'), $shoppingCart);

            $shoppingCart->setShipping($shipping);
        }

        $transform = fractal()
            ->item($shoppingCart)
            ->transformWith(new ShoppingCartTransformer());

        return Response::json($transform->toArray());
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

            return Response::json([
                'success' => false,
                'message' => trans('cart.item_add_failed')
            ], 422);

        }
    }

    public function syncQuantity(Request $request, $item)
    {
        try {

            $quantity = $request->get('quantity', 1);

            $this->cartService->syncQuantity($item, $quantity);

            return Response::json([
                'success' => true,
                'message' => trans('cart.item_quantity_synced')
            ]);

        } catch (Exception $e) {

            return Response::json([
                'success' => false,
                'message' => trans('cart.item_add_failed')
            ], 422);

        }
    }

    public function removeItem($id)
    {
        try {

            $this->cartService->removeItem($id);

            return Response::json([
                'success' => true,
                'message' => trans('cart.item_removed')
            ]);

        } catch (Exception $e) {

            return Response::json([
                'success' => false,
                'message' => trans('cart.item_remove_failed')
            ], 422);
        }
    }

    protected function getShipping($postalCode, ShoppingCartInterface $cart)
    {
        return $this->shippingService->getShippingByLowestPrice(new PostalCode($postalCode), $cart);
    }

}
<?php

namespace Vinci\App\Website\Http\ShoppingCart;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Request;
use Response;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;

class ShoppingCartController extends Controller
{
    private $customerService;

    private $cartService;

    public function __construct(EntityManagerInterface $em, ShoppingCartService $cartService)
    {
        parent::__construct($em);

        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        return $this->view('cart.index');
    }

    public function getItems()
    {

        $items = [
            'id' => 'dfg8dufg9dfg',
            'items' => [
                [
                    'id' => 1,
                    'name' => 'Produto 1',
                    'producer' => 'Catena Zapata',
                    'sale_price' => 40.99,
                    'quantity' => 2,
                    'subtotal' => 81.98
                ],
                [
                    'id' => 2,
                    'name' => 'Produto 2',
                    'producer' => 'Catena Zapata',
                    'sale_price' => 30.45,
                    'quantity' => 1,
                    'subtotal' => 30.45
                ]
            ]
        ];


        return Response::json($items);
    }

    public function add()
    {
        try {

            $this->cartService->addItem(2, 10);

            return Response::json([
                'success' => true,
                'message' => trans('cart.item_added')
            ]);

        } catch (Exception $e) {

            return Response::json([
                'success' => false,
                'message' => trans('cart.item_add_failed')
            ]);

        }
    }

}
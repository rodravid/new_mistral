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
    protected $customerService;
    /**
     * @var ShoppingCartService
     */
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
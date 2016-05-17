<?php

namespace Vinci\App\Website\Http\ShoppingCart;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
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

        $this->cartService->getCart();

        return $request->session()->get('_webeleven_cart_id');

        return($this->cartService->getCart());


        return $this->view('cart.index');
    }

}
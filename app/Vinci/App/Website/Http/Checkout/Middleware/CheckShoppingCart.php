<?php

namespace Vinci\App\Website\Http\Checkout\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Redirect;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;

class CheckShoppingCart
{

    private $cartService;

    public function __construct(ShoppingCartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function handle($request, Closure $next)
    {

        if ($this->notIsConfirmatonRoute() && $this->cartService->isEmpty()) {
            return Redirect::route('cart.index');
        }

        return $next($request);
    }

    protected function notIsConfirmatonRoute()
    {
        return Route::currentRouteName() != 'checkout.confirmation.index';
    }

}
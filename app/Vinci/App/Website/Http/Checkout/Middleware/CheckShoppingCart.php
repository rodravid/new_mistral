<?php

namespace Vinci\App\Website\Http\Checkout\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Redirect;
use Vinci\Domain\Order\Checkers\ShoppingCartChecker;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;

class CheckShoppingCart
{

    private $cartService;

    private $cartChecker;

    public function __construct(ShoppingCartService $cartService, ShoppingCartChecker $cartChecker)
    {
        $this->cartService = $cartService;
        $this->cartChecker = $cartChecker;
    }

    public function handle($request, Closure $next)
    {
        $cart = $this->cartService->getCart();

        if ($this->notIsConfirmationRoute() && ($cart->isEmpty() || $this->cartIsInvalid($cart))) {
            return Redirect::route('cart.index');
        }

        return $next($request);
    }

    protected function notIsConfirmationRoute()
    {
        return Route::currentRouteName() != 'checkout.confirmation.index';
    }

    protected function cartIsInvalid($cart)
    {
        return ! $this->cartChecker->canBeOrdered($cart);
    }

}
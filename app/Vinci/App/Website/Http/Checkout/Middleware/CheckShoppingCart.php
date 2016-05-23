<?php

namespace Vinci\App\Website\Http\Checkout\Middleware;

use Closure;
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
        if ($this->cartService->isEmpty()) {
            return Redirect::route('index');
        }

        return $next($request);
    }

}
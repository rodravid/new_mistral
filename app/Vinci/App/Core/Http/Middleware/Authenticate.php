<?php

namespace Vinci\App\Core\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->to($this->getLoginRedirect($guard));
            }
        }

        return $next($request);
    }

    protected function getLoginRedirect($guard)
    {
        if ($guard == 'cms') {
            return 'cms/login';
        }

        if (Str::contains(URL::previous(), 'carrinho')) {
            return route('login') .'/?r=carrinho';
        }

        return route('login') . '/';
    }
}

<?php

namespace Vinci\App\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

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
                return redirect()->guest($this->getLoginRedirect($guard));
            }
        }

        return $next($request);
    }

    protected function getLoginRedirect($guard)
    {
        if ($guard == 'cms') {
            return 'cms/login';
        }

        return 'login';
    }
}

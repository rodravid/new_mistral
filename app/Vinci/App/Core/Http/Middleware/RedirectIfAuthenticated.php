<?php

namespace Vinci\App\Core\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RedirectIfAuthenticated
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
        if (Auth::guard($guard)->check()) {

            if ($request->ajax() || $request->wantsJson()) {

                return Response::json([
                    'url' => $this->getRedirectPath($guard)
                ]);

            }

            return redirect($this->getRedirectPath($guard));

        }

        return $next($request);
    }

    protected function getRedirectPath($guard)
    {
        if ($guard == 'cms') {
            return route('cms.dashboard.show');
        }

        return route('account.index');
    }
}

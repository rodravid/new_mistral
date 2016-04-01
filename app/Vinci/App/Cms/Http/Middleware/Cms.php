<?php

namespace Vinci\App\Cms\Http\Middleware;

use Closure;
use Illuminate\Routing\Route;
use Vinci\Domain\ACL\ACLService;

class Cms
{
    private $ACLService;

    private $route;

    public function __construct(ACLService $ACLService, Route $route)
    {
        $this->ACLService = $ACLService;
        $this->route = $route;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        return $next($request);
    }

}

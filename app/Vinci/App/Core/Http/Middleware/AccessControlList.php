<?php

namespace Vinci\App\Core\Http\Middleware;


use Closure;
use Illuminate\Routing\Route;
use Vinci\Domain\ACL\ACLService;

class AccessControlList
{
    private $ACLService;

    private $route;

    public function __construct(ACLService $ACLService, Route $route)
    {
        $this->ACLService = $ACLService;
        $this->route = $route;
    }

    public function handle($request, Closure $next)
    {
        if (! $this->ACLService->userCanAccessRoute(cmsUser(), $this->route->getName())) {
            abort(404);
        }

        return $next($request);
    }

}

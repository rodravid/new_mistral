<?php

namespace Vinci\App\Cms\Http\Middleware;

use Closure;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\View;
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
        $module = $this->ACLService->findModuleByPermissionName($this->route->getName());

        if ($module) {
            $this->ACLService->setCurrentModule($module);
            View::share('currentModule', $module);
        }

        return $next($request);
    }

}

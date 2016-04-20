<?php

namespace Vinci\App\Cms\Http\Middleware;

use Closure;
use Vinci\Domain\ACL\Role\RoleRepository;

class PreventSuperAdminRoleManagement
{
    protected $roleRepository;

    protected $preventedRoutes = [
        'cms.roles.edit',
        'cms.roles.update',
        'cms.roles.destroy',
    ];

    public function __construct(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function handle($request, Closure $next)
    {
        if ($this->isManagingSuperAdminRole($request)) {
            abort(404);
        }

        return $next($request);
    }

    protected function isManagingSuperAdminRole($request)
    {
        if (in_array($request->route()->getName(), $this->preventedRoutes)) {

            $role = $this->roleRepository->find($request->route('role'));

            if ($role->isSuperAdmin()) {
               return true;
            }
        }

        return false;
    }

}

<?php

namespace Vinci\Domain\ACL;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\ACL\Module\Module;
use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Domain\ACL\Permission\Permission;
use Vinci\Domain\ACL\Permission\PermissionRepository;
use Vinci\Domain\ACL\Role\Role;
use Vinci\Domain\ACL\Role\RoleRepository;
use Vinci\Domain\User\User;

class ACLService
{
    protected $moduleRepository;

    protected $permissionRepository;

    protected $currentModule;

    protected $entityManager;

    protected $roleRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ModuleRepository $moduleRepository,
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->moduleRepository = $moduleRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function setCurrentModule(Module $module)
    {
        $this->currentModule = $module;
    }

    public function getCurrentModule()
    {
        return $this->currentModule;
    }

    public function buildModulesTreeHtmlForUser(User $user, array $options = [])
    {
        $modules = $this->getModulesForUser($user);

        return $this->moduleRepository->buildTree($modules, $options);
    }

    protected function getModulesForUser(User $user)
    {
        if ($user->isSuperAdmin()) {
            return $this->moduleRepository->getAll();
        }

        return $this->moduleRepository->getFromRoles($user->getRoles());
    }

    public function userCanAccessRoute(User $user, $routeName)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        $permissionName = $this->normalizePermissionName($routeName);

        $permission = $this->permissionRepository->findByName($permissionName);

        if ($this->currentModule && $this->currentModule->canBeManagedBy($user)) {

            if ($permission->extractActionName() == 'list') {
                return true;
            }

            return $user->hasPermissionTo($permissionName);
        }

        return false;
    }

    public function findModuleByPermissionName($permissionName)
    {
        $permissionName = $this->normalizePermissionName($permissionName);

        $permission = $this->permissionRepository->findByName($permissionName);

        return $this->moduleRepository->findByPermission($permission);
    }

    protected function normalizePermissionName($name)
    {
        return explode('#', $name)[0];
    }

    public function getAllPermissionsGroupedByModule()
    {
        $permissions = $this->permissionRepository->getAll();

        $groupedPermissions = [];

        foreach ($permissions as $permission) {
            $module = $this->moduleRepository->findByName($permission->extractModuleName());

            $groupedPermissions[$module->getName()]['module'] = $module;
            $groupedPermissions[$module->getName()]['permissions'][] = $permission;
        }

        return $groupedPermissions;
    }

    public function createRole(array $attributes)
    {
        $role = Role::make([
            'title' => $attributes['title'],
            'description' => $attributes['description']
        ]);

        $this->assingModulesAndPermissions($role, $attributes['modules'], $attributes['permissions']);

        $this->roleRepository->save($role);

        return $role;
    }

    public function updateRole(array $attributes, $id)
    {
        $role = $this->roleRepository->find($id);

        $role->getModules()->clear();
        $role->getPermissions()->clear();

        $this->assingModulesAndPermissions($role, $attributes['modules'], $attributes['permissions']);

        $this->roleRepository->save($role);

        return $role;
    }

    protected function assingModulesAndPermissions(Role $role, array $modules = [], array $permissions = [])
    {
        foreach($modules as $module) {
            $role->assignModule($this->entityManager->getReference(Module::class, $module));
        }

        foreach($permissions as $permission) {
            $role->assignPermission($this->entityManager->getReference(Permission::class, $permission));
        }
    }

}
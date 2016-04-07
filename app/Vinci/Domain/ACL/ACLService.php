<?php

namespace Vinci\Domain\ACL;

use Vinci\Domain\ACL\Module\Module;
use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Domain\User\User;

class ACLService
{
    protected $moduleRepository;

    protected $currentModule;

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
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

        $tree = $this->moduleRepository->buildTree($modules, $options);

        return $tree;
    }

    protected function getModulesForUser(User $user)
    {
        if ($user->isSuperAdmin()) {
            return $this->moduleRepository->getAll();
        }

        return $this->moduleRepository->getFromRoles($user->getRoles());
    }

    public function userCanExecuteAction(User $user, $action)
    {
        $permission = $this->parsePermissionName($action);

        if ($user->isSuperAdmin()) {
            return true;
        }

        if ($this->currentModule) {
            return $this->currentModule->canBeManagedBy($user) && $user->can($permission);
        }

        return false;
    }

    public function findModuleByAction($action)
    {
        $permission = $this->parsePermissionName($action);

        $moduleName = $this->parseModuleName($permission);

        return $this->moduleRepository->findByName($moduleName);
    }

    protected function parsePermissionName($action)
    {
        return explode('#', $action)[0];
    }

    protected function parseModuleName($action)
    {
        $segments = explode('.', $action);
        return $segments[1];
    }

}
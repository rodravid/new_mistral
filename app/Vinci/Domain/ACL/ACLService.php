<?php

namespace Vinci\Domain\ACL;

use Vinci\Domain\ACL\Module\ModuleRepository;
use Vinci\Domain\User\User;

class ACLService
{
    protected $moduleRepository;

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
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
        if ($user->isSuperAdmin()) {
            return true;
        }

        $module = $this->findModuleByAction($action);

        if ($module) {
            return $module->canBeManagedBy($user) && $user->can($action);
        }

        return false;
    }

    protected function findModuleByAction($action)
    {
        $moduleName = $this->parseModuleName($action);

        return $this->moduleRepository->findByName($moduleName);
    }

    protected function parseModuleName($action)
    {
        $segments = explode('.', $action);
        return $segments[1];
    }

}
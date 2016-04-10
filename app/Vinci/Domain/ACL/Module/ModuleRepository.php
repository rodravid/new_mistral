<?php

namespace Vinci\Domain\ACL\Module;

use Doctrine\Common\Collections\Collection;
use Vinci\Domain\ACL\Permission\Permission;

interface ModuleRepository
{

    public function getAll();

    public function getFromRoles(Collection $roles);

    public function findByName($name);

    public function findByPermission(Permission $permission);

}
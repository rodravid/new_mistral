<?php

namespace Vinci\Domain\ACL\Module;

use Doctrine\Common\Collections\Collection;

interface ModuleRepository
{
    public function find($id);

    public function getAll();

    public function getFromRoles(Collection $roles);

    public function findByName($name);

    public function findByPermissionName($name);

}
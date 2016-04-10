<?php

namespace Vinci\Domain\ACL\Permission;


interface PermissionRepository
{

    public function getAll();

    public function findByName($name);

}
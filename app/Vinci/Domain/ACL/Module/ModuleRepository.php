<?php

namespace Vinci\Domain\ACL\Module;


use LaravelDoctrine\ACL\Contracts\HasRoles;

interface ModuleRepository
{

    public function getModulesForUser(HasRoles $user);

    public function findByName($name);

}
<?php

namespace Vinci\Domain\ACL\Module;


use LaravelDoctrine\ACL\Contracts\HasRoles;

interface ModuleRepository
{

    public function findModulesForUser(HasRoles $user);

}
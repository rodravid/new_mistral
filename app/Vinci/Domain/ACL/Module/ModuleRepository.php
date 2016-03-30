<?php

namespace Vinci\Domain\ACL\Module;

use Vinci\Domain\Admin\Admin;

interface ModuleRepository
{

    public function findModulesForAdminUser(Admin $user);

}
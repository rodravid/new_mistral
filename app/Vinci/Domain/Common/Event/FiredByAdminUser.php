<?php

namespace Vinci\Domain\Common\Event;

use Vinci\Domain\Admin\Admin;

interface FiredByAdminUser
{

    public function getUser();

    public function setUser(Admin $user);

}
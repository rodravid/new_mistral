<?php

namespace Vinci\Domain\User\Admin;

use Vinci\Domain\User\User;

class Admin extends User
{

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

}
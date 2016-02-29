<?php

namespace Vinci\Domain\User\Customer;

use Vinci\Domain\User\User;

class Customer extends User
{

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

}
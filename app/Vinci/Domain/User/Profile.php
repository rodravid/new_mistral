<?php

namespace Vinci\Domain\User;

use Vinci\Domain\Core\Model;

class Profile extends Model
{

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

}
<?php

namespace Vinci\Domain\User;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    protected $table = 'users';

    protected $fillable = [
        'name', 'email',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->profile->password;
    }

}
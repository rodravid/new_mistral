<?php

namespace Vinci\Domain\User\Admin;

use Vinci\Domain\User\Profile as BaseProfile;

class Profile extends BaseProfile
{

    protected $table = 'admins_profile';

    protected $fillable = [
        'password',
        'user_id',
        'type',
        'document'
    ];

    protected $hidden = ['password'];

}
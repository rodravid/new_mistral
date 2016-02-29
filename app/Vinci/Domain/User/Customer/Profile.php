<?php

namespace Vinci\Domain\User\Customer;

use Vinci\Domain\User\Profile as BaseProfile;

class Profile extends BaseProfile
{

    protected $table = 'customers_profile';

    protected $fillable = [
        'password',
        'user_id',
        'type',
        'document'
    ];

    protected $hidden = ['password'];

}
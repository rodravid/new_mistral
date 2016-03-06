<?php

namespace Vinci\App\Website\Http\Auth;

use Vinci\App\Core\Http\Controllers\Auth\PasswordController as BaseAuthController;

class PasswordController extends BaseAuthController
{

    protected $linkRequestView = 'website::auth.passwords.email';

}
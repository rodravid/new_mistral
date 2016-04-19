<?php

namespace Vinci\App\Website\Http\Auth;

use Vinci\App\Core\Http\Controllers\Auth\AuthController as BaseAuthController;

class AuthController extends BaseAuthController
{

    protected $guard = 'website';

    protected $loginView = 'website::auth.login';

    protected $redirectTo = '/minha-conta';

    protected $redirectAfterLogout = '/';

}
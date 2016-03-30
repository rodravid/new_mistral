<?php

namespace Vinci\App\Cms\Http\Auth;

use Vinci\App\Core\Http\Controllers\Auth\AuthController as BaseAuthController;

class AuthController extends BaseAuthController
{

    protected $guard = 'cms';

    protected $loginView = 'cms::auth.login';

    protected $redirectTo = '/cms';

    protected $redirectAfterLogout = '/cms';

}
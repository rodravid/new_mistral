<?php

namespace Vinci\App\Cms\Http\Auth;

use Vinci\App\Core\Http\Controllers\Auth\PasswordController as BaseAuthController;

class PasswordController extends BaseAuthController
{

    protected $guard = 'cms';

    protected $broker = 'admins';

    protected $linkRequestView = 'cms::auth.passwords.email';

    protected $resetView = 'cms::auth.passwords.reset';

    protected $redirectPath = '/cms/login';

}
<?php

namespace Vinci\App\Website\Http\Auth;

use Vinci\App\Core\Http\Controllers\Auth\PasswordController as BaseAuthController;

class PasswordController extends BaseAuthController
{

    protected $guard = 'website';

    protected $broker = 'customers';

    protected $linkRequestView = 'website::auth.passwords.email';

    protected $resetView = 'website::auth.passwords.reset';

    protected $redirectPath = '/minha-conta';

}
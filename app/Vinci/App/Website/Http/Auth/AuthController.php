<?php

namespace Vinci\App\Website\Http\Auth;

use Illuminate\Http\Request;
use Vinci\App\Core\Http\Controllers\Auth\AuthController as BaseAuthController;

class AuthController extends BaseAuthController
{

    protected $guard = 'website';

    protected $redirectTo = '/minha-conta';

    protected $loginView = 'website::auth.login';

    protected $auth;



}
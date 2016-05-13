<?php

namespace Vinci\App\Website\Http\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Vinci\App\Core\Http\Controllers\Auth\AuthController as BaseAuthController;

class AuthController extends BaseAuthController
{

    protected $guard = 'website';

    protected $loginView = 'website::auth.login';

    protected $redirectTo = '/minha-conta';

    protected $redirectAfterLogout = '/';

    public function authenticated(Request $request, Authenticatable $user)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'intended' => URL::previous()
            ]);
        }

        return redirect()->intended($this->redirectPath());
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => $this->getFailedLoginMessage()
            ], 401);
        }

        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() => $this->getFailedLoginMessage(),
            ]);
    }

}
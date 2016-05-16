<?php

namespace Vinci\App\Website\Http\Auth;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use URL;
use Vinci\App\Core\Http\Controllers\Auth\AuthController as BaseAuthController;

class AuthController extends BaseAuthController
{

    protected $guard = 'website';

    protected $loginView = 'website::auth.login';

    protected $redirectAfterLogout = '/';

    public function __construct()
    {
        parent::__construct();

        $this->redirectTo = route('account.index');
    }

    public function authenticated(Request $request, Authenticatable $user)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'url' => URL::previous()
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
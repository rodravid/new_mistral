<?php

namespace Vinci\App\Website\Http\Auth;

use Request;
use Vinci\App\Core\Http\Controllers\Auth\PasswordController as BaseAuthController;

class PasswordController extends BaseAuthController
{

    protected $guard = 'website';

    protected $broker = 'customers';

    protected $linkRequestView = 'website::auth.passwords.email';

    protected $resetView = 'website::auth.passwords.reset';

    protected $redirectPath = '/minhaconta';

    protected $subject = 'Vinci Vinhos – Recuperação de senha.';

    protected function getSendResetLinkEmailSuccessResponse($response)
    {
        if (Request::ajax() || Request::wantsJson()) {
            return response()->json([
                'message' => trans($response)
            ]);
        }

        return redirect()->back()->with('status', trans($response));
    }

    protected function getSendResetLinkEmailFailureResponse($response)
    {

        if (Request::ajax() || Request::wantsJson()) {
            return response()->json([
                'message' => trans($response)
            ], 422);
        }

        return redirect()->back()->withErrors(['email' => trans($response)]);
    }

}
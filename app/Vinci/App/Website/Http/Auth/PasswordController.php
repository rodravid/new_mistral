<?php

namespace Vinci\App\Website\Http\Auth;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Request;
use Vinci\App\Core\Http\Controllers\Auth\PasswordController as BasePasswordController;
use Vinci\App\Website\Http\Customer\Presenters\CustomerPresenter;

class PasswordController extends BasePasswordController
{

    protected $guard = 'website';

    protected $broker = 'customers';

    protected $linkRequestView = 'website::auth.passwords.email';

    protected $resetView = 'website::auth.passwords.reset';

    protected $redirectPath = '/minhaconta';

    protected $subject = 'Vinci Vinhos – Recuperação de senha.';

    protected $user;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->shareLoggedUser();
    }

    protected function shareLoggedUser()
    {
        $this->user = Auth::guard('website')->user();

        if ($this->user) {
            view()->share('loggedUser', new CustomerPresenter($this->user));
        }
    }

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
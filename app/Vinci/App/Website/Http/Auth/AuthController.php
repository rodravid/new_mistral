<?php

namespace Vinci\App\Website\Http\Auth;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use URL;
use Vinci\App\Core\Http\Controllers\Auth\AuthController as BaseAuthController;
use Vinci\App\Website\Auth\OldAuthService;
use Vinci\Domain\Customer\CustomerRepository;

class AuthController extends BaseAuthController
{

    protected $guard = 'website';

    protected $loginView = 'website::auth.login';

    protected $redirectAfterLogout = '/';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

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

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $customerRepository = app(CustomerRepository::class);

        $customer = $customerRepository->findByEmail($request->get('email'));

        if (! $customer) {
            return $this->sendFailedLoginResponse($request);
        }

        if ($customer->isOldCustomer()) {

            try {

                $oldAuthService = app(OldAuthService::class);

                $oldAuthService->auth($customer, $request->get('password'));

            } catch (Exception $e) {

                return $this->sendFailedLoginResponse($request);

            }

        }

        return parent::login($request);
    }

}
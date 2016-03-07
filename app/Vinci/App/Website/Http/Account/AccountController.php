<?php

namespace Vinci\App\Website\Http\Account;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\User\Customer\CustomerService;

class AccountController extends Controller
{

    protected $customerService;

    protected $auth;

    public function __construct(CustomerService $customerService, AuthManager $auth)
    {
        $this->customerService = $customerService;
        $this->auth = $auth->guard('website');
    }

    public function index()
    {
        $user = $this->auth->user();

        return $this->view('account.index', compact('user'));
    }

    public function create()
    {
        return $this->view('account.create');
    }

    public function edit()
    {
        $user = $this->auth->user();

        return $this->view('account.create', compact('user'));
    }

    public function store(Request $request)
    {
        try {

            $customer = $this->customerService->create($request->all());

            $this->auth->guard('website')->login($customer);

            return redirect()->route('account.index');

        } catch (ValidationException $e) {

            $this->throwValidationException($request, $e->validator);
        }
    }

    public function update(Request $request, $customerId)
    {
        try {

            $this->customerService->update($request->all(), $customerId);

            return redirect()->route('account.index');

        } catch (ValidationException $e) {

            $this->throwValidationException($request, $e->validator);
        }
    }

}
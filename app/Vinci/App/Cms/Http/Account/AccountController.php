<?php

namespace Vinci\App\Cms\Http\Account;

use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Admin\AdminService;

class AccountController extends Controller
{

    protected $adminService;

    protected $auth;

    public function __construct(AdminService $adminService, AuthManager $auth)
    {
        $this->adminService = $adminService;
        $this->auth = $auth->guard('cms');
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

            $customer = $this->adminService->create($request->all());

            $this->auth->login($customer);

            return redirect()->route('cms.account.index');

        } catch (ValidationException $e) {

            $this->throwValidationException($request, $e->validator);
        }
    }

    public function update(Request $request, $customerId)
    {
        try {

            $this->adminService->update($request->all(), $customerId);

            return redirect()->route('cms.account.index');

        } catch (ValidationException $e) {

            $this->throwValidationException($request, $e->validator);
        }
    }

}
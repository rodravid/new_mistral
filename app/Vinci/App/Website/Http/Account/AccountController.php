<?php

namespace Vinci\App\Website\Http\Account;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Customer\CustomerService;

class AccountController extends Controller
{
    protected $customerService;

    protected $auth;

    public function __construct(EntityManagerInterface $em, CustomerService $customerService)
    {
        parent::__construct($em);

        $this->customerService = $customerService;
    }

    public function index()
    {
        return Redirect::route('account.orders.index');
    }

    public function edit()
    {
        $customer = $this->user;

        return $this->view('account.info.index', compact('customer'));
    }

    public function update(Request $request, $customerId)
    {
        try {

            $this->customerService->update($request->all(), $customerId);

            return redirect()->route('account.edit');

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }
    }

}
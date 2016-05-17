<?php

namespace Vinci\App\Website\Http\Register;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Address\State\StateRepository;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Customer\CustomerService;

class RegisterController extends Controller
{
    protected $customerService;

    protected $stateRepository;

    public function __construct(
        EntityManagerInterface $em,
        CustomerService $customerService,
        StateRepository $stateRepository
    )
    {
        parent::__construct($em);

        $this->customerService = $customerService;
        $this->stateRepository = $stateRepository;
    }

    public function index()
    {
        $states = $this->stateRepository->getByCountry(Country::BRAZIL);

        return $this->view('register.index', compact('states'));
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $customer = $this->customerService->create($data);

            Auth::login($customer);

            return Redirect::route('account.index');

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }
    }

}
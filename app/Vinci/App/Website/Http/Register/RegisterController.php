<?php

namespace Vinci\App\Website\Http\Register;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Log;
use Redirect;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Address\Country\Country;
use Vinci\Domain\Address\PublicPlaceRepository;
use Vinci\Domain\Address\State\StateRepository;
use Vinci\Domain\Customer\CustomerService;

class RegisterController extends Controller
{
    protected $customerService;

    protected $stateRepository;

    protected $publicPlaceRepository;

    public function __construct(
        EntityManagerInterface $em,
        CustomerService $customerService,
        StateRepository $stateRepository,
        PublicPlaceRepository $publicPlaceRepository
    ) {
        parent::__construct($em);

        $this->customerService = $customerService;
        $this->stateRepository = $stateRepository;
        $this->publicPlaceRepository = $publicPlaceRepository;
    }

    public function index()
    {
        $states = $this->stateRepository->getByCountry(Country::BRAZIL);
        $publicPlaces = $this->publicPlaceRepository->getAll();

        return $this->view('register.index', compact('states', 'publicPlaces'));
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $data['addresses'][0]['receiver'] = $data['name'];

            $customer = $this->customerService->create($data);

            Auth::login($customer);

            return Redirect::route('account.index');

        } catch (ValidationException $e) {

            return Redirect::back()
                ->withErrors($e->getErrors())
                ->withInput();

        } catch (Exception $e) {

            Log::error(sprintf('Register error: %s', $e->getMessage()));

            Flash::error(trans('register.failed'));

            return Redirect::back()->withInput();

        }
    }

}
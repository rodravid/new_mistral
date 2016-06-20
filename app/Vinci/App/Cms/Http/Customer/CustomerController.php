<?php

namespace Vinci\App\Cms\Http\Customer;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Cms\Http\Customer\Presenters\CustomerPresenter;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Address\City\CityRepository;
use Vinci\Domain\Address\Country\CountryRepository;
use Vinci\Domain\Address\PublicPlaceRepository;
use Vinci\Domain\Address\State\StateRepository;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Customer\CustomerService;

class CustomerController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = 'Vinci\Infrastructure\Customer\Datatables\CustomerCmsDatatable';

    protected $countryRepository;

    protected $stateRepository;

    protected $cityRepository;

    protected $publicPlaceRepository;

    public function __construct(
        EntityManagerInterface $em,
        CustomerService $service,
        CustomerRepository $repository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        CityRepository $cityRepository,
        PublicPlaceRepository $publicPlaceRepository
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
        $this->publicPlaceRepository = $publicPlaceRepository;
    }

    public function index()
    {
        return $this->view('customers.list');
    }

    public function create()
    {
        $country = $this->countryRepository->find(Country::BRAZIL);

        $states = $this->stateRepository->getByCountry($country);

        $publicPlaces = $this->publicPlaceRepository->getAll();

        return $this->view('customers.create', compact('country', 'states', 'publicPlaces'));
//            ->withCountry($country)
//            ->withStates($states)
//            ->withPublicPlaces($publicPlaces);
    }

    public function edit($id)
    {
        $customer = $this->repository->findOrFail($id);

        $country = $this->countryRepository->find(Country::BRAZIL);

        $states = $this->stateRepository->getByCountry($country);

        return $this->view('customers.edit')
            ->withCustomer($customer)
            ->withCountry($country)
            ->withStates($states);
    }

    public function show($id)
    {
        $customer = $this->repository->findOrFail($id);

        $customer = $this->presenter->model($customer, CustomerPresenter::class);

        return $this->view('customers.show')
            ->withCustomer($customer);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $customer = $this->service->create($data);

            Flash::success("Cliente {$customer->getName()} criado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $customer->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }
    }

    public function update(Request $request, $customerId)
    {
        try {

            $data = $request->all();

            $customer = $this->service->update($data, $customerId);

            Flash::success("Cliente {$customer->getName()} atualizado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $customer->getId())
                ->withInput(['current-tab' => $request->get('current-tab')]);

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($customerId)
    {
        $customer = $this->repository->find($customerId);

        try {

            $this->repository->delete($customer);

            Flash::success("Cliente {$customer->getName()} excluído com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }
}
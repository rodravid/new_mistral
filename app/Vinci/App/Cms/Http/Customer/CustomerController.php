<?php

namespace Vinci\App\Cms\Http\Customer;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Cms\Http\Customer\Presenters\CustomerPresenter;
use Vinci\App\Cms\Http\Order\Presenters\OrderPresenter;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Integration\ERP\Logger\IntegrationLogger;
use Vinci\Domain\Address\City\CityRepository;
use Vinci\Domain\Address\Country\Country;
use Vinci\Domain\Address\Country\CountryRepository;
use Vinci\Domain\Address\PublicPlaceRepository;
use Vinci\Domain\Address\State\StateRepository;
use Vinci\Domain\Customer\Address\AddressRepository;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Customer\CustomerService;
use Vinci\Domain\Order\OrderRepository;

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

    protected $addressRepository;

    protected $orderRepository;

    public function __construct(
        EntityManagerInterface $em,
        CustomerService $service,
        CustomerRepository $repository,
        AddressRepository $addressRepository,
        CountryRepository $countryRepository,
        StateRepository $stateRepository,
        CityRepository $cityRepository,
        PublicPlaceRepository $publicPlaceRepository,
        OrderRepository $orderRepository
    ) {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
        $this->publicPlaceRepository = $publicPlaceRepository;
        $this->addressRepository = $addressRepository;
        $this->orderRepository = $orderRepository;
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
    }

    public function edit($id)
    {
        $customer = $this->repository->findOrFail($id);

        $country = $this->countryRepository->find(Country::BRAZIL);

        $states = $this->stateRepository->getByCountry($country);

        $publicPlaces = $this->publicPlaceRepository->getAll();

        return $this->view('customers.edit', compact('customer', 'country', 'states', 'publicPlaces'));
    }

    public function show($id)
    {
        $customer = $this->repository->findOrFail($id);
        $customer = $this->presenter->model($customer, CustomerPresenter::class);

        $addresses = $this->addressRepository->getAllByCustomer($id);

        $orders = $this->orderRepository->getByCustomer($id, 10);
        $orders = $this->presenter->paginator($orders, OrderPresenter::class);

        $integrationLogs = IntegrationLogger::type('customer')->getByResourceId($customer->id);

        return $this->view('customers.show', compact('customer', 'addresses', 'orders', 'integrationLogs'));
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
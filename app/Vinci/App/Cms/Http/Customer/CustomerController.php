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
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Customer\CustomerService;

class CustomerController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = 'Vinci\Infrastructure\Customer\Datatables\CustomerCmsDatatable';

    protected $roleRepository;

    protected $imageRepository;

    public function __construct(
        EntityManagerInterface $em,
        CustomerService $service,
        CustomerRepository $repository
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->view('customers.list');
    }

    public function create()
    {
        return $this->view('customers.create');
    }

    public function edit($id)
    {
        $customer = $this->repository->findOrFail($id);

        return $this->view('customers.edit')
            ->withCustomer($customer);
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
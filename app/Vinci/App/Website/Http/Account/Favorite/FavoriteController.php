<?php

namespace Vinci\App\Website\Http\Account\Favorite;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Customer\CustomerService;
use Vinci\Domain\Order\OrderRepository;

class FavoriteController extends Controller
{
    protected $customerService;

    public function __construct(EntityManagerInterface $em, CustomerService $customerService)
    {
        parent::__construct($em);

        $this->customerService = $customerService;
    }

    public function index(OrderRepository $orderRepository)
    {
//        $customer = $this->auth->user();
//
//        //$orders = $customer->getOrders();
//
//        $orders = $orderRepository->getByCustomer($customer->getId());

        return $this->view('account.favorite.index');
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

            $this->auth->login($customer);

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
<?php

namespace Vinci\App\Website\Http\Account\Order;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Customer\CustomerService;
use Vinci\Domain\Order\OrderRepository;

class OrderController extends Controller
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

        return $this->view('account.orders.index');
    }

    public function show($id)
    {
        return $this->view('account.orders.show');
    }

}
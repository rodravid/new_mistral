<?php

namespace Vinci\App\Website\Http\Account\Order;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Order\Presenter\OrderPresenter;
use Vinci\App\Website\Http\Presenters\DefaultPaginatorPresenter;
use Vinci\Domain\Order\OrderRepository;

class OrderController extends Controller
{

    protected $orderRepository;

    public function __construct(EntityManagerInterface $em, OrderRepository $orderRepository)
    {
        parent::__construct($em);

        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $customer = $this->user;

        $orders = $this->orderRepository->getByCustomer($customer->getId());

        $orders = $this->presenter->paginator($orders, OrderPresenter::class);

        $orders = $this->presenter->model($orders, DefaultPaginatorPresenter::class);

        return $this->view('account.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = $this->orderRepository->getOneById($id);

        $order = $this->presenter->model($order, OrderPresenter::class);

        return $this->view('account.orders.show', compact('order'));
    }

}
<?php

namespace Vinci\App\Cms\Http\Order;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Cms\Http\Order\Presenters\OrderPresenter;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\Domain\Order\OrderRepository;
use Vinci\Domain\Order\OrderService;

class OrderController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = 'Vinci\Infrastructure\Orders\Datatables\OrderCmsDatatable';

    public function __construct(
        EntityManagerInterface $em,
        OrderService $service,
        OrderRepository $repository
    ) {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->view('orders.list');
    }

    public function show($id)
    {
        $order = $this->repository->getOneById($id);

        $order = $this->presenter->model($order, OrderPresenter::class);

        return $this->view('orders.show')->withOrder($order);
    }

}
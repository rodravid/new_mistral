<?php

namespace Vinci\App\Website\Http\Checkout\Confirmation;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Order\Presenter\OrderPresenter;
use Vinci\Domain\Order\OrderRepository;

class ConfirmationController extends Controller
{

    protected $customerService;

    protected $orderRepository;

    public function __construct(EntityManagerInterface $em, OrderRepository $orderRepository)
    {
        parent::__construct($em);

        $this->orderRepository = $orderRepository;
    }

    public function index($orderId)
    {
        $order = $this->presenter->model($this->getOrder($orderId), OrderPresenter::class);

        return $this->view('checkout.confirmation.index', compact('order'));
    }

    protected function getOrder($id)
    {
        return $this->orderRepository->getOneById($id);
    }

}
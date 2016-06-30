<?php

namespace Vinci\App\Website\Http\Account\Order;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Redirect;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Order\Presenter\OrderPresenter;
use Vinci\App\Website\Http\Presenters\DefaultPaginatorPresenter;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\Order\OrderRepository;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;

class OrderController extends Controller
{

    protected $orderRepository;

    protected $cartService;

    public function __construct(
        EntityManagerInterface $em,
        OrderRepository $orderRepository,
        ShoppingCartService $cartService
    ) {
        parent::__construct($em);

        $this->orderRepository = $orderRepository;
        $this->cartService = $cartService;
    }

    public function index()
    {
        $customer = $this->user;

        $orders = $this->orderRepository->getByCustomer($customer->getId());

        $orders = $this->presenter->paginator($orders, OrderPresenter::class);

        $orders = $this->presenter->model($orders, DefaultPaginatorPresenter::class);

        return $this->view('account.orders.index', compact('orders'));
    }

    public function show($number)
    {
        $order = $this->orderRepository->getOneByNumber($number);

        $this->preventNotOwnedOrder($order);

        $order = $this->presenter->model($order, OrderPresenter::class);

        return $this->view('account.orders.show', compact('order'));
    }

    public function repeat($number)
    {
        $order = $this->orderRepository->getOneByNumber($number);

        $this->preventNotOwnedOrder($order);

        $errors = [];

        foreach ($order->getItems() as $item) {

            $variant = $item->getProductVariant();

            try {

                $this->cartService->addItem($variant, $item->getQuantity());

            } catch (Exception $e) {
                $errors[] = sprintf('O produto %s não pode ser adicionado no carrinho.', $variant->getTitle());
            }

        }

        if (empty($errors)) {
            Flash::success('Os items foram adicionados ao seu carrinho.');
        } else {
            Flash::error('Alguns items não puderam ser adicionados no carrinho.');
        }

        return Redirect::route('account.orders.show', [$order->getNumber()]);
    }

    protected function preventNotOwnedOrder(OrderInterface $order)
    {
        if (! $order->isOwnedBy($this->user)) {
            abort(404);
        }
    }

}
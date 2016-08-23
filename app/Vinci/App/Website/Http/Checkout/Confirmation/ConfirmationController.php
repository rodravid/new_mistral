<?php

namespace Vinci\App\Website\Http\Checkout\Confirmation;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\Order\Presenter\OrderPresenter;
use Vinci\App\Website\Http\Order\Transformers\TransactionProductsTagTransformer;
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

    public function index($orderNumber)
    {
        $order = $this->getOrder($orderNumber);

        $googleTransactionProducts = $this->makeGoogleTransactionProducts($order);

        $order = $this->presenter->model($order, OrderPresenter::class);

        if (! $order->isOwnedBy($this->user)) {
            abort(404);
        }

        return $this->view('checkout.confirmation.index', compact('order', 'googleTransactionProducts'));
    }

    private function makeGoogleTransactionProducts($order)
    {
        if ($order->getGoogleTag() == false) {
            $order->setGoogleTag(true);

            $tag = fractal()
                ->item($order)
                ->transformWith(new TransactionProductsTagTransformer)
                ->toJson();

            $this->orderRepository->save($order);

            return $tag;
        }

        return false;
    }

    protected function getOrder($number)
    {
        return $this->orderRepository->getOneByNumber($number);
    }

}
<?php

namespace Vinci\App\Website\Http\Checkout\Payment;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Checkout\Payment\Request\PaymentRequest;
use Vinci\App\Website\Http\Checkout\Presenters\AddressPresenter;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\ShoppingCart\Presenters\ShoppingCartPresenter;
use Vinci\Domain\Customer\Address\AddressRepository;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;

class PaymentController extends Controller
{
    protected $cartService;

    protected $addressRepository;

    public function __construct(
        EntityManagerInterface $em,
        ShoppingCartService $cartService,
        AddressRepository $addressRepository
    ) {
        parent::__construct($em);

        $this->cartService = $cartService;
        $this->addressRepository = $addressRepository;
    }

    public function index(PaymentRequest $request)
    {
        $deliveryAddress = $this->getDeliveryAddress($request);

        $shoppingCart = $this->presenter->model($this->cartService->getCart(), ShoppingCartPresenter::class);

        return $this->view('checkout.payment.index', compact('shoppingCart', 'deliveryAddress'));
    }

    protected function getDeliveryAddress(PaymentRequest $request)
    {
        $deliveryAddress = $this->addressRepository->getOneById($request->get('address_id'));

        return $this->presenter->model($deliveryAddress, AddressPresenter::class);
    }

}
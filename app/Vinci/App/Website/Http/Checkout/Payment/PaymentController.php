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

        $months = $this->getMonths();
        $years = $this->getYears();

        return $this->view('checkout.payment.index', compact('shoppingCart', 'deliveryAddress', 'months', 'years'));
    }

    protected function getDeliveryAddress(PaymentRequest $request)
    {
        $deliveryAddress = $this->addressRepository->getOneById($request->get('address_id'));

        return $this->presenter->model($deliveryAddress, AddressPresenter::class);
    }

    protected function getYears()
    {
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear + 10);
        return array_combine($years, $years);
    }

    protected function getMonths()
    {
        return [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];
    }

}
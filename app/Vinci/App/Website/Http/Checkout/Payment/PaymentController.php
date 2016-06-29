<?php

namespace Vinci\App\Website\Http\Checkout\Payment;

use Doctrine\ORM\EntityManagerInterface;
use Response;
use Vinci\App\Website\Http\Checkout\Payment\Request\PaymentRequest;
use Vinci\App\Website\Http\Checkout\Presenters\AddressPresenter;
use Vinci\App\Website\Http\Controller;
use Vinci\App\Website\Http\ShoppingCart\Presenters\ShoppingCartPresenter;
use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Customer\Address\AddressRepository;
use Vinci\Domain\Payment\Services\InstallmentCaculator;
use Vinci\Domain\Shipping\Services\ShippingService;
use Vinci\Domain\ShoppingCart\Services\ShoppingCartService;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class PaymentController extends Controller
{
    protected $cartService;

    protected $addressRepository;

    protected $shippingService;

    public function __construct(
        EntityManagerInterface $em,
        ShoppingCartService $cartService,
        AddressRepository $addressRepository,
        ShippingService $shippingService
    ) {
        parent::__construct($em);

        $this->cartService = $cartService;
        $this->addressRepository = $addressRepository;
        $this->shippingService = $shippingService;
    }

    public function index(PaymentRequest $request)
    {
        $deliveryAddress = $this->getDeliveryAddress($request);

        $shoppingCart = $this->cartService->getCart();

        $shipping = $this->getShipping($deliveryAddress->getPostalCode(), $shoppingCart);

        $shoppingCart = $this->presenter->model($this->cartService->getCart(), ShoppingCartPresenter::class);

        $shoppingCart->setShipping($shipping);

        $months = $this->getMonths();
        $years = $this->getYears();

        $installmentOptions = [
            1 => '1x de ' . $shoppingCart->total
        ];

        return $this->view('checkout.payment.index', compact('shoppingCart', 'deliveryAddress', 'months', 'years', 'installmentOptions'));
    }

    protected function getDeliveryAddress(PaymentRequest $request)
    {
        $deliveryAddress = $this->addressRepository->getOneById($request->get('address_id'));

        return $this->presenter->model($deliveryAddress, AddressPresenter::class);
    }

    protected function getShipping($postalCode, ShoppingCartInterface $cart)
    {
        return $this->shippingService->getShippingByLowestPrice(new PostalCode($postalCode), $cart);
    }

    protected function getYears()
    {
        $currentYear = date('Y');
        $years = range($currentYear, $currentYear + 10);
        return array_combine($years, $years);
    }

    protected function getMonths()
    {
        return getMonths();
    }

    public function getInstallmentOptions(PaymentRequest $request)
    {
        $data = $request->all();

        $shoppingCart = $this->cartService->getCart();

        $deliveryAddress = $this->getDeliveryAddress($request);

        $shipping = $this->getShipping($deliveryAddress->getPostalCode(), $shoppingCart);

        $shoppingCart->setShipping($shipping);

        $installments = with(app(InstallmentCaculator::class))->getInstallmentOptions($shoppingCart->getTotal(), $data['paymentMethod']);

        $options = [];
        foreach ($installments as $installment) {

            $options[$installment['quantity']] = $installment['label'];

        }

        return Response::json($options);
    }

}
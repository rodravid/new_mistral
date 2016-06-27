<?php

namespace Vinci\Domain\Order;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Order\Factory\OrderFactory;
use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Order\Validators\OrderCreditCardValidator;
use Vinci\Domain\Order\Validators\OrderValidator;
use Vinci\Domain\Payment\CreditCard;
use Vinci\Domain\Payment\Payment;
use Vinci\Domain\Payment\PaymentMethod;
use Vinci\Domain\Payment\Repositories\PaymentMethodsRepository;
use Vinci\Domain\Shipping\Services\ShippingService;
use Vinci\Domain\Shipping\Shipment;

class OrderService
{

    protected $entityManager;

    protected $orderValidator;

    protected $creditCardValidator;

    protected $factory;

    protected $shippingService;

    protected $eventDispatcher;

    private $paymentMethodRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderValidator $orderValidator,
        OrderCreditCardValidator $creditCardValidator,
        OrderFactory $factory,
        ShippingService $shippingService,
        Dispatcher $eventDispatcher,
        PaymentMethodsRepository $paymentMethodsRepository
    ) {
        $this->entityManager = $entityManager;
        $this->orderValidator = $orderValidator;
        $this->creditCardValidator = $creditCardValidator;
        $this->factory = $factory;
        $this->shippingService = $shippingService;
        $this->eventDispatcher = $eventDispatcher;
        $this->paymentMethodRepository = $paymentMethodsRepository;
    }

    public function create(array $data)
    {
        $this->orderValidator->with($data)->passesOrFail();

        $data = $this->getPaymentMethodType($data);

        if (array_get($data, 'payment.method_type') == "credit_card") {
            $this->creditCardValidator->with($data)->passesOrFail();
        }

        return $this->entityManager->transactional(function ($em) use ($data) {

            $order = $this->factory->make($data);

            $shipment = $this->getShipment($order);

            $order->setShipment($shipment);

            $order->setShoppingCart($this->getShoppingCart($data));

            $payment = $this->getPayment($data);

            $payment->setAmount($order->getTotal());

            $order->addPayment($payment);

            $em->persist($order);

            $this->dispatchOrderEvents($order);

            return $order;
        });
    }

    protected function dispatchOrderEvents(OrderInterface $order)
    {
        foreach ($order->releaseEvents() as $event) {
            $this->eventDispatcher->fire($event);
        }
    }

    protected function getShipment(OrderInterface $order)
    {
        $postalCode = new PostalCode($order->getShippingAddress()->getPostalCode());

        $shippingOption = $this->shippingService->getShippingByLowestPrice($postalCode, $order);

        $shipment = new Shipment;

        $shipment
            ->setCarrier($shippingOption->getCarrier())
            ->setDeadline($shippingOption->getDeadline())
            ->setAmount($shippingOption->getPrice());

        return $shipment;
    }

    protected function getPayment(array $data)
    {
        $payment = new Payment;

        $paymentMethod = $this->getPaymentMethod($data);

        $payment->setMethod($paymentMethod);

        if ($data['payment']['method_type'] == "credit_card"){

            $creditCard = $this->getCreditCard($data);
            $creditCard->setBrand($paymentMethod->getCode());

            $payment = $payment
                ->setCreditCard($creditCard)
                ->setInstallments($this->getPaymentInstallments($data));

        }

        return $payment;
    }

    protected function getCreditCard(array $data)
    {
        $card = new CreditCard;

        $card
            ->setHolderName(array_get($data, 'card.holdername'))
            ->setNumber(array_get($data, 'card.number'))
            ->setExpiryMonth(array_get($data, 'card.expiry_month'))
            ->setExpiryYear(array_get($data, 'card.expiry_year'))
            ->setSecurityCode(array_get($data, 'card.security_code'));

        return $card;
    }

    protected function getShoppingCart(array $data)
    {
        return array_get($data, 'cart');
    }

    protected function getCustomer($data)
    {
        return array_get($data, 'customer');
    }

    protected function getPaymentInstallments(array $data)
    {
        return array_get($data, 'payment.installments');
    }

    protected function getPaymentMethod($data)
    {
        return $this->entityManager->getReference(PaymentMethod::class, array_get($data, 'payment.method'));
    }

    protected function getPaymentMethodType($data)
    {
        $data['payment']['method_type'] = $this->paymentMethodRepository->findOneById($data['payment']['method'])[0]->getDescription();
        return $data;
    }

}
<?php

namespace Vinci\Domain\Order;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Order\Factory\OrderFactory;
use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Payment\CreditCard;
use Vinci\Domain\Payment\Payment;
use Vinci\Domain\Payment\PaymentMethod;
use Vinci\Domain\Shipping\Services\ShippingService;
use Vinci\Domain\Shipping\Shipment;

class OrderService
{

    protected $entityManager;

    protected $validator;

    protected $factory;

    protected $shippingService;

    protected $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderValidator $validator,
        OrderFactory $factory,
        ShippingService $shippingService,
        Dispatcher $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->factory = $factory;
        $this->shippingService = $shippingService;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->entityManager->transactional(function($em) use ($data) {

            $order = $this->factory->make($data);

            $shipment = $this->getShipment($order);

            $order->setShipment($shipment);

            $order->setShoppingCart($this->getShoppingCart($data));

            $payment = $this->getPayment($data);

            $payment->setAmount($order->getTotal());

            $order->addPayment($payment);

            $this->dispatchOrderEvents($order);

            $em->persist($order);

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

        $creditCard = $this->getCreditCard($data);

        $creditCard->setBrand($paymentMethod->getCode());

        $payment
            ->setMethod($paymentMethod)
            ->setCreditCard($creditCard)
            ->setInstallments($this->getPaymentInstallments($data));

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

}
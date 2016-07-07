<?php

namespace Vinci\Domain\Order;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcher;
use Illuminate\Support\MessageBag;
use Inacho\CreditCard as CreditCardNumberValidator;
use InvalidArgumentException;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Common\Event\FiredByAdminUser;
use Vinci\Domain\Order\Commands\ChangeOrderStatusCommand;
use Vinci\Domain\Order\Exceptions\InvalidItemsException;
use Vinci\Domain\Order\Factory\OrderFactory;
use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Order\Factory\OrderItemFactory;
use Vinci\Domain\Order\Item\ValidItemsFilter;
use Vinci\Domain\Order\Jobs\SendOrderStatusMail;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatus;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatusRepository;
use Vinci\Domain\Order\Validators\OrderValidator;
use Vinci\Domain\Payment\CreditCard;
use Vinci\Domain\Payment\Payment;
use Vinci\Domain\Payment\PaymentMethod;
use Vinci\Domain\Payment\Repositories\PaymentMethodsRepository;
use Vinci\Domain\Payment\Validators\CreditCardValidator;
use Vinci\Domain\Shipping\Services\ShippingService;
use Vinci\Domain\Shipping\Shipment;
use Vinci\Domain\ShoppingCart\Exceptions\InvalidShoppingCartException;

class OrderService
{

    protected $entityManager;

    protected $orderValidator;

    protected $creditCardValidator;

    protected $factory;

    protected $orderItemFactory;

    protected $shippingService;

    protected $eventDispatcher;

    protected $paymentMethodRepository;

    protected $bus;

    protected $trackingStatusRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderValidator $orderValidator,
        CreditCardValidator $creditCardValidator,
        OrderFactory $factory,
        OrderItemFactory $orderItemFactory,
        ShippingService $shippingService,
        Dispatcher $eventDispatcher,
        BusDispatcher $bus,
        PaymentMethodsRepository $paymentMethodsRepository,
        OrderTrackingStatusRepository $trackingStatusRepository
    ) {
        $this->entityManager = $entityManager;
        $this->orderValidator = $orderValidator;
        $this->creditCardValidator = $creditCardValidator;
        $this->factory = $factory;
        $this->orderItemFactory = $orderItemFactory;
        $this->shippingService = $shippingService;
        $this->eventDispatcher = $eventDispatcher;
        $this->bus = $bus;
        $this->paymentMethodRepository = $paymentMethodsRepository;
        $this->trackingStatusRepository = $trackingStatusRepository;
    }

    public function create(array $data)
    {
        $this->orderValidator->with($data)->passesOrFail();

        $data = $this->getPaymentMethodType($data);
        
        if (array_get($data, 'payment.method_type') == "credit_card") {
            $this->validateCreditCard($data);
        }

        $items = $this->getOrderItems($data);

        return $this->entityManager->transactional(function ($em) use ($data, $items) {

            $order = $this->factory->make($data);

            $order->setItems($items);

            $shipment = $this->getShipment($order);

            $order->setShipment($shipment);

            $order->setShoppingCart($this->getShoppingCart($data));

            $payment = $this->getPayment($data);

            $payment->setAmount($order->getTotal());

            $order->addPayment($payment);

            $order->setTrackingStatus($this->getTrackingStatus());

            $em->persist($order);

            $this->dispatchOrderEvents($order);

            return $order;
        });
    }

    protected function getOrderItems(array $data)
    {
        $items = $this->orderItemFactory->makeFromShoppingCart($this->getShoppingCart($data));

        $items = (new ValidItemsFilter())->filter($items);

        if (! $items->count()) {
            throw new InvalidShoppingCartException('The shopping cart given does not contains valid items.');
        }

        return $items;
    }

    protected function dispatchOrderEvents(OrderInterface $order)
    {
        foreach ($order->releaseEvents() as $event) {

            if ($event instanceof FiredByAdminUser) {
                $event->setUser(Auth::guard('cms')->user());
            }

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

    public function changeOrderStatus(ChangeOrderStatusCommand $command)
    {
        $this->entityManager->transactional(function($em) use ($command) {

            $order = $command->getOrder();

            $orderTtackingStatus = $this->normalizeTrackingStatus($command->getOrderTrackingStatus());

            $order->changeStatus($command->getOrderStatus());
            $order->changePaymentStatus($command->getPaymentStatus());
            $order->changeTrackingStatus($orderTtackingStatus);

            $em->persist($order);

            $this->dispatchOrderEvents($order);

        });

        if ($command->shouldSendMail()) {
            $this->bus->dispatchNow(new SendOrderStatusMail($command->getOrder(), $command->getMailSubject(), $command->getMailBody()));
        }
    }

    protected function normalizeTrackingStatus($status)
    {
        return is_object($status)
            ? $status : $this->entityManager->getReference(OrderTrackingStatus::class, $status);
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

    protected function getTrackingStatus()
    {
        try {
            return $this->trackingStatusRepository->getOneByCode(OrderTrackingStatus::STATUS_NEW);

        } catch (Exception $e) {
            throw new InvalidArgumentException(sprintf('Order tracking status not found by code: %s', OrderTrackingStatus::STATUS_NEW));
        }
    }

    private function validateCreditCard(array $data)
    {
        $paymentMethod = $this->getPaymentMethod($data);

        $this->creditCardValidator->with($data)->passesOrFail();

        if(! CreditCardNumberValidator::validCreditCard(only_numbers(array_get($data, 'card.number')), $paymentMethod->getName())['valid']) {
            throw new ValidationException(new MessageBag([
                'card.number' => 'Cartão de crédito inválido para a bandeira selecionada.'
            ]));
        }
    }

}
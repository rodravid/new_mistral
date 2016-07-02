<?php

namespace Vinci\Domain\Order\Events\Subscribers;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Order\Events\OrderStatusWasChanged;
use Vinci\Domain\Order\Events\OrderTrackingStatusWasChanged;
use Vinci\Domain\Order\Events\PaymentStatusWasChanged;
use Vinci\Domain\Order\History\OrderHistoryEntryBuilder;

class OrderStatusSubscriber
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function onOrderStatusChanges(OrderStatusWasChanged $event)
    {
        $order = $event->getOrder();

        OrderHistoryEntryBuilder::make($this->em)
            ->user($event->getUser())
            ->handle($order)
            ->changingOldStatus($event->getOldStatus())
            ->toNewStatus($order->getStatus())
            ->save();
    }

    public function onOrderTrackingStatusChanges(OrderTrackingStatusWasChanged $event)
    {
        $order = $event->getOrder();

        OrderHistoryEntryBuilder::make($this->em)
            ->user($event->getUser())
            ->handle($order)
            ->changingOldTrackingStatus($event->getOldStatus()->getId())
            ->toNewStatus($order->getTrackingStatus()->getId())
            ->save();
    }

    public function onOrderPaymentStatusChanges(PaymentStatusWasChanged $event)
    {
        $payment = $event->getPayment();

        OrderHistoryEntryBuilder::make($this->em)
            ->user($event->getUser())
            ->handle($payment->getOrder())
            ->changingOldPaymentStatus($event->getOldStatus())
            ->toNewStatus($payment->getStatus())
            ->save();
    }

    public function subscribe($events)
    {
        $events->listen(
            'Vinci\Domain\Order\Events\OrderStatusWasChanged',
            'Vinci\Domain\Order\Events\Subscribers\OrderStatusSubscriber@onOrderStatusChanges'
        );

        $events->listen(
            'Vinci\Domain\Order\Events\OrderTrackingStatusWasChanged',
            'Vinci\Domain\Order\Events\Subscribers\OrderStatusSubscriber@onOrderTrackingStatusChanges'
        );

        $events->listen(
            'Vinci\Domain\Order\Events\PaymentStatusWasChanged',
            'Vinci\Domain\Order\Events\Subscribers\OrderStatusSubscriber@onOrderPaymentStatusChanges'
        );
    }

}
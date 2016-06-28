<?php

namespace Vinci\Domain\Order\Events;

use Vinci\Domain\Common\Event\Event;
use Vinci\Domain\Payment\PaymentInterface;

class PaymentStatusWasChanged extends Event
{

    private $payment;

    private $oldStatus;

    public function __construct(PaymentInterface $payment, $oldStatus)
    {
        $this->payment = $payment;
        $this->oldStatus = $oldStatus;
    }

    public function getPayment()
    {
        return $this->payment;
    }

    public function getOldStatus()
    {
        return $this->oldStatus;
    }

}
<?php

namespace Vinci\Domain\Order\Commands;

use Vinci\Domain\Order\OrderInterface;

class ChangeOrderStatusCommand
{

    private $order;
    private $orderStatus;
    private $paymentStatus;
    private $orderTrackingStatus;
    private $shouldSendMail;
    private $mailSubject;
    private $mailBody;

    public function __construct(
        OrderInterface $order,
        $orderStatus = null,
        $paymentStatus = null,
        $orderTrackingStatus = null,
        $shouldSendMail = false,
        $mailSubject = null,
        $mailBody = null
    ) {

        $this->order = $order;
        $this->orderStatus = $orderStatus;
        $this->paymentStatus = $paymentStatus;
        $this->orderTrackingStatus = $orderTrackingStatus;
        $this->shouldSendMail = $shouldSendMail;
        $this->mailSubject = $mailSubject;
        $this->mailBody = $mailBody;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getOrderStatus()
    {
        return $this->orderStatus;
    }

    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    public function getOrderTrackingStatus()
    {
        return $this->orderTrackingStatus;
    }

    public function shouldSendMail()
    {
        return (bool) $this->shouldSendMail;
    }

    public function getMailSubject()
    {
        return $this->mailSubject;
    }

    public function getMailBody()
    {
        return $this->mailBody;
    }

}
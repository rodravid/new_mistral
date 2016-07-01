<?php

namespace Vinci\Domain\Payment;

use Vinci\Domain\Order\OrderInterface;

interface PaymentInterface
{
    public function getMethod();

    public function setMethod(PaymentMethodInterface $method = null);

    public function getCreditCard();

    public function setCreditCard(CreditCardInterface $card);

    public function getStatus();

    public function setStatus($status);

    public function getAmount();

    public function setAmount($amount);

    public function getOrder();

    public function setOrder(OrderInterface $order = null);

}
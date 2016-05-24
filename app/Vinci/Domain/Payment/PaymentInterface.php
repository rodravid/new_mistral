<?php

namespace Vinci\Domain\Payment;

use Vinci\Domain\Order\OrderInterface;

interface PaymentInterface
{

    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_AUTHORIZED = 'authorized';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_VOID = 'void';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_UNKNOWN = 'unknown';

    public function getMethod();

    public function setMethod(PaymentMethodInterface $method = null);

    public function getStatus();

    public function setStatus($status);

    public function getAmount();

    public function setAmount($amount);

    public function getOrder();

    public function setOrder(OrderInterface $order = null);

}
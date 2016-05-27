<?php

namespace Vinci\Domain\Order;

use Vinci\Domain\Shipping\ShippableInterface;

interface OrderInterface extends ShippableInterface
{

    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_VOID = 'void';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_UNKNOWN = 'unknown';

}
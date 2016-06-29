<?php

namespace Vinci\Domain\Order;

use Vinci\Domain\Common\Enum;

class OrderStatus extends Enum
{
    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_UNKNOWN = 'unknown';

    protected static $labels = [
        self::STATUS_NEW => 'Novo',
        self::STATUS_PENDING => 'Pendente',
        self::STATUS_PROCESSING => 'Processando',
        self::STATUS_COMPLETED => 'Completo',
        self::STATUS_CANCELLED => 'Aprovado',
        self::STATUS_REFUNDED => 'Reembolsado',
        self::STATUS_UNKNOWN => 'Desconhecido'
    ];

}
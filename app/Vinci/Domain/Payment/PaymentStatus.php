<?php

namespace Vinci\Domain\Payment;

use Vinci\Domain\Common\Enum;

class PaymentStatus extends Enum
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

    protected static $labels = [
        self::STATUS_NEW => 'Novo pagamento',
        self::STATUS_PENDING => 'Pendente',
        self::STATUS_PROCESSING => 'Processando',
        self::STATUS_COMPLETED => 'Completo',
        self::STATUS_AUTHORIZED => 'Autorizado',
        self::STATUS_FAILED => 'Falhou',
        self::STATUS_CANCELLED => 'Cancelado',
        self::STATUS_REFUNDED => 'Reembolsado',
        self::STATUS_UNKNOWN => 'Desconhecido'
    ];

}
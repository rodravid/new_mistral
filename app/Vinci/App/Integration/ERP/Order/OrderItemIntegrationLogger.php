<?php

namespace Vinci\App\Integration\ERP\Order;

use Vinci\App\Integration\ERP\Logger\IntegrationLogger;

class OrderItemIntegrationLogger extends IntegrationLogger
{

    protected $table = 'orders_items_integration_logs';

    protected $fillable = [
        'user',
        'type',
        'resource_owner_id',
        'resource_id',
        'message',
        'error_message',
        'error_trace',
        'request_body',
        'response_body'
    ];

}
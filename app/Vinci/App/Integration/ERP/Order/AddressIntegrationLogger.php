<?php

namespace Vinci\App\Integration\ERP\Order;

use Vinci\App\Integration\ERP\Logger\IntegrationLogger;

class AddressIntegrationLogger extends IntegrationLogger
{

    protected $table = 'orders_shipping_address_integration_logs';

    protected $fillable = [
        'user',
        'type',
        'resource_owner_id',
        'resource_id',
        'message',
        'error_message',
        'error_trace',
        'request_type',
        'request_body',
        'response_body'
    ];

}
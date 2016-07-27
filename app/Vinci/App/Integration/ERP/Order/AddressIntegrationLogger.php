<?php

namespace Vinci\App\Integration\ERP\Order;

use Vinci\App\Integration\ERP\Logger\IntegrationLogger;
use Vinci\Domain\Order\OrderRepository;

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

    protected $order;

    public function getResourceTypeAttribute()
    {
        return 'address';
    }

    public function getOrder()
    {
        if (! is_null($this->order)) {
            return $this->order;
        }

        return $this->order = app(OrderRepository::class)->getOneById($this->resource_id);
    }

}
<?php

namespace Vinci\App\Integration\ERP\Order;

use Vinci\App\Integration\ERP\Logger\IntegrationLogger;
use Vinci\Domain\Order\OrderRepository;

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

    protected $item;

    public function getResourceTypeAttribute()
    {
        return 'order_item';
    }

    public function getItem()
    {
        if (! is_null($this->item)) {
            return $this->item;
        }

        return $this->item = app(OrderRepository::class)->getItemById($this->resource_id);
    }

}
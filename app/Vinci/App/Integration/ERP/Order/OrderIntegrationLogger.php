<?php

namespace Vinci\App\Integration\ERP\Order;

use Vinci\App\Integration\ERP\Logger\IntegrationLogger;
use Vinci\Domain\Order\OrderRepository;

class OrderIntegrationLogger extends IntegrationLogger
{

    protected $table = 'orders_integration_logs';

    protected $order;

    public function getResourceTypeAttribute()
    {
        return 'order';
    }

    public function getOrder()
    {
        if (! is_null($this->order)) {
            return $this->order;
        }

        return $this->order = app(OrderRepository::class)->getOneById($this->resource_id);
    }

}
<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Vinci\App\Integration\ERP\Order\OrderExporter;
use Vinci\Domain\Order\Events\NewOrderWasCreated;

class SendOrderToIntegrationQueue
{

    private $orderExporter;

    public function __construct(OrderExporter $orderExporter)
    {
        $this->orderExporter = $orderExporter;
    }

    public function handle(NewOrderWasCreated $event)
    {
        $this->orderExporter->exportQueued($event->order, true);
    }

}
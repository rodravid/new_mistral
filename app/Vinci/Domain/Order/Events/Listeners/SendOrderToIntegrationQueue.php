<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Illuminate\Contracts\Bus\Dispatcher;
use Vinci\App\Integration\ERP\Order\Jobs\ExportOrderToErp;
use Vinci\Domain\Order\Events\NewOrderWasCreated;

class SendOrderToIntegrationQueue
{

    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(NewOrderWasCreated $event)
    {
        $this->dispatcher->dispatch(
            (new ExportOrderToErp($event->order->getId()))
                ->onQueue('vinci-integration-orders')
        );
    }

}
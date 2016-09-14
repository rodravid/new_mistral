<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Config\Repository;
use Vinci\Domain\Order\Events\NewOrderWasCreated;
use Vinci\Domain\Order\Jobs\SendOrderConfirmationMail as SendOrderConfirmationMailJob;

class SendOrderConfirmationMail
{

    private $dispatcher;

    private $config;

    public function __construct(Dispatcher $dispatcher, Repository $config)
    {
        $this->dispatcher = $dispatcher;
        $this->config = $config;
    }

    public function handle(NewOrderWasCreated $event)
    {
        $job = (new SendOrderConfirmationMailJob($event->order->getId()))
            ->onQueue($this->config->get('queue.orders-emails'));

        $this->dispatcher->dispatch($job);
    }

}
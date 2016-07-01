<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Illuminate\Contracts\Bus\Dispatcher;
use Vinci\Domain\Order\Events\NewOrderWasCreated;
use Vinci\Domain\Order\Jobs\SendOrderConfirmationMail as SendOrderConfirmationMailJob;

class SendOrderConfirmationMail
{

    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(NewOrderWasCreated $event)
    {
        $job = (new SendOrderConfirmationMailJob($event->order->getId()))->onQueue('emails');

        $this->dispatcher->dispatch($job);
    }

}
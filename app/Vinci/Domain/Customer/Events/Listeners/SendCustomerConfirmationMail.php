<?php

namespace Vinci\Domain\Customer\Events\Listeners;

use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Config\Repository;
use Vinci\Domain\Customer\Events\CustomerWasCreated;
use Vinci\Domain\Customer\Jobs\SendCustomerConfirmationMail as SendCustomerConfirmationMailJob;

class SendCustomerConfirmationMail
{

    private $dispatcher;

    private $config;

    public function __construct(Dispatcher $dispatcher, Repository $config)
    {
        $this->dispatcher = $dispatcher;
        $this->config = $config;
    }

    public function handle(CustomerWasCreated $event)
    {
        $job = (new SendCustomerConfirmationMailJob($event->customer->getId()))
            ->onQueue($this->config->get('queue.customers-emails'));

        $this->dispatcher->dispatch($job);
    }

}
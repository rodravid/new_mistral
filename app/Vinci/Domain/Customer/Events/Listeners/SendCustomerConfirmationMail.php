<?php

namespace Vinci\Domain\Customer\Events\Listeners;

use Illuminate\Contracts\Bus\Dispatcher;
use Vinci\Domain\Customer\Events\CustomerWasCreated;
use Vinci\Domain\Customer\Jobs\SendCustomerConfirmationMail as SendCustomerConfirmationMailJob;

class SendCustomerConfirmationMail
{

    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(CustomerWasCreated $event)
    {
        $job = (new SendCustomerConfirmationMailJob($event->customer->getId()))
            ->onQueue('vinci-email-customers');

        $this->dispatcher->dispatch($job);
    }

}
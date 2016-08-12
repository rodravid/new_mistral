<?php

namespace Vinci\Domain\Customer\Events\Listeners;

use Illuminate\Contracts\Bus\Dispatcher;
use Vinci\Domain\Customer\Events\CustomerWasUpdated;
use Vinci\Domain\Customer\Jobs\SendCustomerAccountUpdateMail as SendCustomerAccountUpdateMailJob;

class SendCustomerAccountUpdateMail
{

    private $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function handle(CustomerWasUpdated $event)
    {
        $this->dispatcher->dispatch(new SendCustomerAccountUpdateMailJob($event->customer));
    }

}
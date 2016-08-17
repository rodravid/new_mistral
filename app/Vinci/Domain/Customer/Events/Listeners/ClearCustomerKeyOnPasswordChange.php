<?php

namespace Vinci\Domain\Customer\Events\Listeners;

use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Customer\Events\CustomerPasswordWasChanged;

class ClearCustomerKeyOnPasswordChange
{

    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function handle(CustomerPasswordWasChanged $event)
    {
        $event->customer->clearCryptKey();
        $this->customerRepository->save($event->customer);
    }

}
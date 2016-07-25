<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Vinci\App\Integration\ERP\Customer\CustomerExporter;
use Vinci\Domain\Order\Events\NewOrderWasCreated;

class SendCustomerToIntegrationQueue
{

    private $customerExporter;

    public function __construct(CustomerExporter $customerExporter)
    {
        $this->customerExporter = $customerExporter;
    }

    public function handle(NewOrderWasCreated $event)
    {
        $this->customerExporter->exportQueued(
            $event->getOrder()->getCustomer()
        );
    }

}
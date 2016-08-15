<?php

namespace Vinci\Domain\ERP\Customer\Events\Listeners;

use Vinci\App\Integration\ERP\Customer\CustomerIntegrationLogger;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\ERP\Customer\Events\CustomerSaveOnErpFailed;
use Vinci\Domain\ERP\Customer\Events\CustomerWasSavedOnErp;

class CustomerEventSubscriber
{

    private $customerRepository;

    public function onCustomerSavedOnErp(CustomerWasSavedOnErp $event)
    {
        $localCustomer = $event->getCommand()->getCustomer();

        $localCustomer->changeErpIntegrationStatus(IntegrationStatus::INTEGRATED);

        $this->getCustomerRepository()->save($localCustomer);

        CustomerIntegrationLogger::success([
            'user' => $event->getCommand()->getUserActor(),
            'resource_id' => $localCustomer->getId(),
            'message' => sprintf('Cliente %s integrado com sucesso!', $localCustomer->getName()),
            'request_body' => $event->getRequest(),
            'response_body' => $event->getResponse()
        ]);
    }

    public function onCustomerSaveOnErpFailed(CustomerSaveOnErpFailed $event)
    {
        $localCustomer = $event->getCommand()->getCustomer();

        $localCustomer->changeErpIntegrationStatus(IntegrationStatus::FAILED);

        $this->getCustomerRepository()->save($localCustomer);

        CustomerIntegrationLogger::error([
            'user' => $event->getCommand()->getUserActor(),
            'resource_id' => $localCustomer->getId(),
            'message' => sprintf('Falha ao integrar cliente %s.', $localCustomer->getName()),
            'error_message' => $event->getException()->getMessage(),
            'error_trace' => $event->getException()->getTraceAsString(),
            'request_body' => $event->getRequest(),
            'response_body' => $event->getResponse()
        ]);
    }

    public function subscribe($events)
    {
        $events->listen(
            'Vinci\Domain\ERP\Customer\Events\CustomerWasSavedOnErp',
            'Vinci\Domain\ERP\Customer\Events\Listeners\CustomerEventSubscriber@onCustomerSavedOnErp'
        );

        $events->listen(
            'Vinci\Domain\ERP\Customer\Events\CustomerSaveOnErpFailed',
            'Vinci\Domain\ERP\Customer\Events\Listeners\CustomerEventSubscriber@onCustomerSaveOnErpFailed'
        );
    }

    private function getCustomerRepository()
    {
        if ($this->customerRepository != null) {
            return $this->customerRepository;
        }

        return $this->customerRepository = app(CustomerRepository::class);
    }

}
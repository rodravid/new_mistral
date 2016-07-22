<?php

namespace Vinci\Domain\Order\Events\Listeners;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Bus\Dispatcher;
use Vinci\App\Integration\ERP\Customer\Jobs\ExportCustomerToErp;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\Order\Events\NewOrderWasCreated;

class SendCustomerToIntegrationQueue
{

    private $dispatcher;

    private $entityManager;

    public function __construct(Dispatcher $dispatcher, EntityManagerInterface $entityManager)
    {
        $this->dispatcher = $dispatcher;
        $this->entityManager = $entityManager;
    }

    public function handle(NewOrderWasCreated $event)
    {
        $customer = $event->getOrder()->getCustomer();

        $customer->changeErpIntegrationStatus(IntegrationStatus::PENDING);

        $this->entityManager->persist($customer);
        $this->entityManager->flush();

        $this->dispatcher->dispatch(
            (new ExportCustomerToErp($event->getOrder()->getCustomer()->getId()))
                ->onQueue('vinci-integration-customers')
        );
    }

}
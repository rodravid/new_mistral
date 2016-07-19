<?php

namespace Vinci\Domain\ERP\Order\Events\Listeners;

use Vinci\App\Integration\ERP\Order\OrderIntegrationLogger;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\ERP\Order\Events\OrderCreationErpFailed;
use Vinci\Domain\ERP\Order\Events\OrderWasCreatedOnErp;
use Vinci\Domain\Order\OrderRepository;
use Vinci\Domain\ERP\Order\Events\OrderSaveOnErpFailed;
use Vinci\Domain\ERP\Order\Events\OrderWasSavedOnErp;

class OrderEventSubscriber
{

    private $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function onOrderCreatedOnErp(OrderWasCreatedOnErp $event)
    {
        $localOrder = $event->getCommand()->getOrder();

        $localOrder->changeErpIntegrationStatus(IntegrationStatus::INTEGRATED);

        $this->orderRepository->save($localOrder);

        OrderIntegrationLogger::success([
            'user' => $event->getCommand()->getUserActor(),
            'resource_id' => $localOrder->getId(),
            'message' => sprintf('Pedido #%s integrado com sucesso!', $localOrder->getNumber()),
            'request_body' => $event->getRequest(),
            'response_body' => $event->getResponse()
        ]);
    }

    public function onOrderCreationFailed(OrderCreationErpFailed $event)
    {
        $localOrder = $event->getCommand()->getOrder();

        $localOrder->changeErpIntegrationStatus(IntegrationStatus::FAILED);

        $this->orderRepository->save($localOrder);

        OrderIntegrationLogger::error([
            'user' => $event->getCommand()->getUserActor(),
            'resource_id' => $localOrder->getId(),
            'message' => sprintf('Falha ao integrar pedido #%s.', $localOrder->getNumber()),
            'error_message' => $event->getException()->getMessage(),
            'error_trace' => $event->getException()->getTraceAsString(),
            'request_body' => $event->getRequest(),
            'response_body' => $event->getResponse()
        ]);
    }

    public function subscribe($events)
    {
        $events->listen(
            'Vinci\Domain\ERP\Order\Events\OrderWasCreatedOnErp',
            'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber@onOrderCreatedOnErp'
        );

        $events->listen(
            'Vinci\Domain\ERP\Order\Events\OrderCreationErpFailed',
            'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber@onOrderCreationFailed'
        );
    }

}
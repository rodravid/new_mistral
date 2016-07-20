<?php

namespace Vinci\Domain\ERP\Order\Events\Listeners;

use Vinci\App\Integration\ERP\Order\OrderIntegrationLogger;
use Vinci\App\Integration\ERP\Order\OrderItemIntegrationLogger;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\ERP\Order\Events\OrderCreationErpFailed;
use Vinci\Domain\ERP\Order\Events\OrderItemCreationErpFailed;
use Vinci\Domain\ERP\Order\Events\OrderItemWasCreatedOnErp;
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

    public function onOrderItemCreatedOnErp(OrderItemWasCreatedOnErp $event)
    {
        $item = $event->getCommand()->getItem();

        $item->changeErpIntegrationStatus(IntegrationStatus::INTEGRATED);

        $this->orderRepository->save($item);

        OrderItemIntegrationLogger::success([
            'user' => $event->getCommand()->getUserActor(),
            'resource_owner_id' => $item->getOrder()->getId(),
            'resource_id' => $item->getId(),
            'message' => sprintf('Item #%s integrado com sucesso ao pedido #%s!', $item->getId(), $item->getOrder()->getNumber()),
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

    public function onOrderItemCreationFailed(OrderItemCreationErpFailed $event)
    {
        $item = $event->getCommand()->getItem();

        $item->changeErpIntegrationStatus(IntegrationStatus::FAILED);

        $this->orderRepository->save($item);

        OrderItemIntegrationLogger::error([
            'user' => $event->getCommand()->getUserActor(),
            'resource_owner_id' => $item->getOrder()->getId(),
            'resource_id' => $item->getId(),
            'message' => sprintf('Falha ao integrar item #%s ao pedido #%s.', $item->getId(), $item->getOrder()->getNumber()),
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
            'Vinci\Domain\ERP\Order\Events\OrderItemWasCreatedOnErp',
            'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber@onOrderItemCreatedOnErp'
        );

        $events->listen(
            'Vinci\Domain\ERP\Order\Events\OrderCreationErpFailed',
            'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber@onOrderCreationFailed'
        );

        $events->listen(
            'Vinci\Domain\ERP\Order\Events\OrderItemCreationErpFailed',
            'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber@onOrderItemCreationFailed'
        );
    }

}
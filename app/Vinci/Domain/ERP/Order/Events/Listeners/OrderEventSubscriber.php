<?php

namespace Vinci\Domain\ERP\Order\Events\Listeners;

use Vinci\App\Integration\ERP\Order\AddressIntegrationLogger;
use Vinci\App\Integration\ERP\Order\OrderIntegrationLogger;
use Vinci\App\Integration\ERP\Order\OrderItemIntegrationLogger;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\ERP\Order\Events\AddressErpChecked;
use Vinci\Domain\ERP\Order\Events\AddressErpCheckFailed;
use Vinci\Domain\ERP\Order\Events\OrderCreationErpFailed;
use Vinci\Domain\ERP\Order\Events\OrderItemCreationErpFailed;
use Vinci\Domain\ERP\Order\Events\OrderItemWasCreatedOnErp;
use Vinci\Domain\ERP\Order\Events\OrderWasCreatedOnErp;
use Vinci\Domain\ERP\Order\Events\ShippingAddressUpdateFailed;
use Vinci\Domain\ERP\Order\Events\ShippingAddressWasUpdated;
use Vinci\Domain\Order\OrderRepository;

class OrderEventSubscriber
{

    private $orderRepository;

    public function onOrderCreatedOnErp(OrderWasCreatedOnErp $event)
    {
        $localOrder = $event->getCommand()->getOrder();

        $localOrder->changeErpIntegrationStatus(IntegrationStatus::INTEGRATED);

        $this->getOrderRepository()->save($localOrder);

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

        $this->getOrderRepository()->save($item);

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

        $this->getOrderRepository()->save($localOrder);

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

        $this->getOrderRepository()->save($item);

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

    public function onAddressErpChecked(AddressErpChecked $event)
    {
        $address = $event->getCommand()->getAddress();

        $this->getOrderRepository()->save($address);

        AddressIntegrationLogger::success([
            'user' => $event->getCommand()->getUserActor(),
            'resource_owner_id' => $address->getOrder()->getId(),
            'resource_id' => $address->getId(),
            'message' => sprintf('Endereço de entrega do pedido #%s checado com sucesso.', $address->getOrder()->getNumber()),
            'request_type' => 'get',
            'request_body' => $event->getRequest(),
            'response_body' => $event->getResponse()
        ]);
    }

    public function onAddressErpCheckFailed(AddressErpCheckFailed $event)
    {
        $address = $event->getCommand()->getAddress();

        AddressIntegrationLogger::error([
            'user' => $event->getCommand()->getUserActor(),
            'resource_owner_id' => $address->getOrder()->getId(),
            'resource_id' => $address->getId(),
            'message' => sprintf('Falha ao checar endereço de entrega do pedido #%s no ERP.', $address->getOrder()->getNumber()),
            'error_message' => $event->getException()->getMessage(),
            'error_trace' => $event->getException()->getTraceAsString(),
            'request_type' => 'get',
            'request_body' => $event->getRequest(),
            'response_body' => $event->getResponse()
        ]);
    }

    public function onShippingAddressWasUpdated(ShippingAddressWasUpdated $event)
    {
        $address = $event->getCommand()->getAddress();

        $address->changeErpIntegrationStatus(IntegrationStatus::INTEGRATED);

        $this->getOrderRepository()->save($address);

        AddressIntegrationLogger::success([
            'user' => $event->getCommand()->getUserActor(),
            'resource_owner_id' => $address->getOrder()->getId(),
            'resource_id' => $address->getId(),
            'message' => sprintf('Endereço de entrega do pedido #%s atualizado com sucesso.', $address->getOrder()->getNumber()),
            'request_type' => 'update',
            'request_body' => $event->getRequest(),
            'response_body' => $event->getResponse()
        ]);
    }

    public function onShippingAddressUpdateFailed(ShippingAddressUpdateFailed $event)
    {
        $address = $event->getCommand()->getAddress();

        $address->changeErpIntegrationStatus(IntegrationStatus::FAILED);

        $this->getOrderRepository()->save($address);

        AddressIntegrationLogger::error([
            'user' => $event->getCommand()->getUserActor(),
            'resource_owner_id' => $address->getOrder()->getId(),
            'resource_id' => $address->getId(),
            'message' => sprintf('Falha ao atualizar endereço de entrega do pedido #%s no ERP.', $address->getOrder()->getNumber()),
            'error_message' => $event->getException()->getMessage(),
            'error_trace' => $event->getException()->getTraceAsString(),
            'request_type' => 'update',
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

        $events->listen(
            'Vinci\Domain\ERP\Order\Events\AddressErpChecked',
            'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber@onAddressErpChecked'
        );

        $events->listen(
            'Vinci\Domain\ERP\Order\Events\AddressErpCheckFailed',
            'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber@onAddressErpCheckFailed'
        );

        $events->listen(
            'Vinci\Domain\ERP\Order\Events\ShippingAddressWasUpdated',
            'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber@onShippingAddressWasUpdated'
        );

        $events->listen(
            'Vinci\Domain\ERP\Order\Events\ShippingAddressUpdateFailed',
            'Vinci\Domain\ERP\Order\Events\Listeners\OrderEventSubscriber@onShippingAddressUpdateFailed'
        );
    }

    private function getOrderRepository()
    {
        if ($this->orderRepository != null) {
            return $this->orderRepository;
        }

        return $this->orderRepository = app(OrderRepository::class);
    }

}
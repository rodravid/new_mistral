<?php

namespace Vinci\App\Integration\ERP\Order;

use Exception;
use Vinci\Domain\ERP\Order\Commands\CreateOrderItemCommand;
use Vinci\Domain\ERP\Order\Commands\GetShippingAddressIdCommand;
use Vinci\Domain\ERP\Order\Commands\SaveOrderCommand;
use Vinci\Domain\ERP\Order\Commands\UpdateShippingAddressCommand;
use Vinci\Domain\Order\Item\OrderItem;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\ERP\Order\OrderService;

class OrderExporter
{

    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function export(OrderInterface $localOrder)
    {
        try {

            $this->orderService->getShippingAddressId(
                (new GetShippingAddressIdCommand($localOrder->getShippingAddress()))
                    ->silent()
            );

            $this->orderService->updateShippingAddress(
                (new UpdateShippingAddressCommand($localOrder->getShippingAddress()))
                    ->silent()
            );

            $this->orderService->create(new SaveOrderCommand($localOrder));

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function exportItem(OrderItem $item)
    {
        try {

            $this->orderService->createItem(new CreateOrderItemCommand($item));

        } catch (Exception $e) {
            throw $e;
        }
    }

}
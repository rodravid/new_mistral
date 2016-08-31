<?php

namespace Vinci\App\Integration\ERP\Order;

use Exception;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Config\Repository;
use Vinci\App\Integration\ERP\Customer\CustomerExporter;
use Vinci\App\Integration\ERP\Order\Jobs\ExportOrderToErp;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\ERP\Order\Commands\CreateOrderItemCommand;
use Vinci\Domain\ERP\Order\Commands\GetShippingAddressIdCommand;
use Vinci\Domain\ERP\Order\Commands\SaveOrderCommand;
use Vinci\Domain\ERP\Order\Commands\UpdateShippingAddressCommand;
use Vinci\Domain\Order\Item\OrderItem;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\ERP\Order\OrderService;
use Vinci\Domain\Order\OrderRepository;

class OrderExporter
{

    private $orderService;

    private $orderRepository;

    private $commandDispatcher;

    private $customerExporter;

    private $config;

    const INTEGRATION_QUEUE = 'vinci-integration-orders';

    public function __construct(
        OrderService $orderService,
        OrderRepository $orderRepository,
        CustomerExporter $customerExporter,
        Dispatcher $commandDispatcher,
        Repository $config
    ) {
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
        $this->commandDispatcher = $commandDispatcher;
        $this->customerExporter = $customerExporter;
        $this->config = $config;
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
        } finally {
            app('em')->clear();
        }
    }

    public function exportQueued(OrderInterface $order, $withCustomer = false)
    {
        if ($withCustomer) {
            $this->customerExporter->exportQueued($order->getCustomer());
        }

        $order->changeErpIntegrationStatus(IntegrationStatus::PENDING);

        $this->orderRepository->save($order);

        $this->commandDispatcher->dispatch(
            (new ExportOrderToErp($order->getId()))
                ->onQueue($this->config->get('queue.orders-integration'))
        );
    }

    public function exportItem(OrderItem $item)
    {
        try {

            $this->orderService->createItem(new CreateOrderItemCommand($item));

        } catch (Exception $e) {
            throw $e;
        } finally {
            app('em')->clear();
        }
    }

}
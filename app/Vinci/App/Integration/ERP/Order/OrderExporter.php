<?php

namespace Vinci\App\Integration\ERP\Order;

use Exception;
use Vinci\Domain\ERP\Order\Commands\SaveOrderCommand;
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

            $this->orderService->create(new SaveOrderCommand($localOrder));

        } catch (Exception $e) {
            throw $e;
        }
    }

}
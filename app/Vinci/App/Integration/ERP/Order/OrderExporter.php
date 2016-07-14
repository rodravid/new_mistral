<?php

namespace Vinci\App\Integration\ERP\Order;

use Exception;
use Log;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\ERP\Order\OrderService;
use Vinci\Domain\ERP\Order\OrderTranslator;

class OrderExporter
{

    private $orderService;

    private $orderTranslator;

    public function __construct(OrderService $orderService, OrderTranslator $orderTranslator)
    {
        $this->orderService = $orderService;
        $this->orderTranslator = $orderTranslator;
    }

    public function export(OrderInterface $localOrder)
    {
        try {

            $order = $this->orderTranslator->translate($localOrder);

            $this->orderService->create($order);

        } catch (Exception $e) {

            $this->log($e, $localOrder);

            throw $e;
        }
    }

    private function log(Exception $e, OrderInterface $localOrder)
    {
        Log::error(sprintf('Error during export order #%s: %s', $localOrder->getId(), $e->getMessage()));
    }

}
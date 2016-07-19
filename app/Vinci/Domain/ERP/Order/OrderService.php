<?php

namespace Vinci\Domain\ERP\Order;

use Exception;
use Vinci\Domain\ERP\BaseErpService;
use Vinci\Domain\ERP\Exceptions\ErpException;
use Vinci\Domain\ERP\Order\Commands\SaveOrderCommand;
use Vinci\Domain\ERP\Order\Events\OrderCreationErpFailed;
use Vinci\Domain\ERP\Order\Events\OrderWasCreatedOnErp;
use Vinci\Infrastructure\ERP\EnvelopeFactory;
use Illuminate\Contracts\Events\Dispatcher;

class OrderService extends BaseErpService
{

    private $orderRepository;

    private $orderTranslator;

    public function __construct(
        EnvelopeFactory $envelopeFactory,
        Dispatcher $dispatcher,
        OrderRepository $orderRepository,
        OrderTranslator $orderTranslator
    ) {
        parent::__construct($envelopeFactory, $dispatcher);

        $this->orderRepository = $orderRepository;
        $this->orderTranslator = $orderTranslator;
    }

    public function create(SaveOrderCommand $command)
    {
        try {

            $order = $this->orderTranslator->translate($command->getOrder());

            $request = $this->envelopeFactory->make($order, 'create');

            $response = $this->orderRepository->create($order);

            if (! empty($erpOrderId = $response->getOrderId())) {

                $command->getOrder()->setErpNumber($erpOrderId);

                $this->eventDispatcher->fire(
                    new OrderWasCreatedOnErp($command, $request, $response->getRaw())
                );

                return $response;
            }

            throw new ErpException('Error when creating order on erp.', $response);

        } catch (Exception $e) {

            $response = $e instanceof ErpException ? $e->getResponse()->getRaw() : '';

            $request = isset($request) ? $request : '';

            $this->eventDispatcher->fire(
                new OrderCreationErpFailed($command, $request, $response, $e)
            );

            throw $e;
        }
    }

    public function createOrderItem()
    {

    }

}
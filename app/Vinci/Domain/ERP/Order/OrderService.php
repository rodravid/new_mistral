<?php

namespace Vinci\Domain\ERP\Order;

use Exception;
use Vinci\App\Integration\Exceptions\CustomerNotIntegratedException;
use Vinci\Domain\ERP\BaseErpService;
use Vinci\Domain\ERP\Exceptions\ErpException;
use Vinci\Domain\ERP\Order\Commands\CreateOrderItemCommand;
use Vinci\Domain\ERP\Order\Commands\GetShippingAddressIdCommand;
use Vinci\Domain\ERP\Order\Commands\SaveOrderCommand;
use Vinci\Domain\ERP\Order\Commands\UpdateShippingAddressCommand;
use Vinci\Domain\ERP\Order\Events\AddressErpChecked;
use Vinci\Domain\ERP\Order\Events\AddressErpCheckFailed;
use Vinci\Domain\ERP\Order\Events\OrderCreationErpFailed;
use Vinci\Domain\ERP\Order\Events\OrderItemCreationErpFailed;
use Vinci\Domain\ERP\Order\Events\OrderItemWasCreatedOnErp;
use Vinci\Domain\ERP\Order\Events\OrderWasCreatedOnErp;
use Vinci\Domain\ERP\Order\Events\ShippingAddressUpdateFailed;
use Vinci\Domain\ERP\Order\Events\ShippingAddressWasUpdated;
use Vinci\Domain\ERP\Order\Item\ItemTranslator;
use Vinci\Domain\ERP\Order\Shipping\AddressTranslator;
use Vinci\Infrastructure\ERP\EnvelopeFactory;
use Illuminate\Contracts\Events\Dispatcher;

class OrderService extends BaseErpService
{

    private $orderRepository;

    private $orderTranslator;

    private $itemTranslator;

    private $addressTranslator;

    public function __construct(
        EnvelopeFactory $envelopeFactory,
        Dispatcher $dispatcher,
        OrderRepository $orderRepository,
        OrderTranslator $orderTranslator,
        ItemTranslator $itemTranslator,
        AddressTranslator $addressTranslator
    ) {
        parent::__construct($envelopeFactory, $dispatcher);

        $this->orderRepository = $orderRepository;
        $this->orderTranslator = $orderTranslator;
        $this->itemTranslator = $itemTranslator;
        $this->addressTranslator = $addressTranslator;
    }

    public function create(SaveOrderCommand $command)
    {
        try {

            $order = $this->orderTranslator->translate($command->getOrder());

            $request = $this->envelopeFactory->make($order, 'create');

            if (! $command->getOrder()->getCustomer()->wasIntegrated()) {
                throw new CustomerNotIntegratedException(sprintf('The customer has not yet been integrated.'));
            }

            $response = $this->orderRepository->create($order);

            if (! empty($erpOrderId = $response->getOrderId())) {

                $command->getOrder()->setErpNumber($erpOrderId);

                $this->eventDispatcher->fire(
                    new OrderWasCreatedOnErp($command, $request, $response->getRaw())
                );

                $this->createOrderItems($command);

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

    protected function createOrderItems(SaveOrderCommand $command)
    {
        foreach ($command->getOrder()->getItems() as $item) {
            $this->createItem(
                (new CreateOrderItemCommand($item, $command->getUserActor()))
                    ->silent()
            );
        }
    }

    public function createItem(CreateOrderItemCommand $command)
    {
        try {

            $item = $this->itemTranslator->translate($command->getItem());

            $request = $this->envelopeFactory->make($item, 'create');

            $response = $this->orderRepository->createItem($item);

            if ($response->wasSuccessfullyCreated()) {

                $this->eventDispatcher->fire(
                    new OrderItemWasCreatedOnErp($command, $request, $response->getRaw())
                );

                return $response;
            }

            throw new ErpException('Error when creating order item on erp.', $response);

        } catch (Exception $e) {

            $response = $e instanceof ErpException ? $e->getResponse()->getRaw() : '';

            $request = isset($request) ? $request : '';

            $this->eventDispatcher->fire(
                new OrderItemCreationErpFailed($command, $request, $response, $e)
            );

            if (! $command->isSilent()) {
                throw $e;
            }

        }
    }

    public function getShippingAddressId(GetShippingAddressIdCommand $command)
    {
        try {

            $address = $this->addressTranslator->translate($command->getAddress());

            $request = $this->envelopeFactory->make($address, 'get');

            $response = $this->orderRepository->getShippingAddressId($address);

            if (! empty($addressId = $response->getAddressId())) {

                $command->getAddress()->setCode($addressId);

                $this->eventDispatcher->fire(
                    new AddressErpChecked($command, $request, $response->getRaw())
                );

                return $response;
            }

            throw new ErpException('No address found.', $response);

        } catch (Exception $e) {

            $response = $e instanceof ErpException ? $e->getResponse()->getRaw() : '';

            $request = isset($request) ? $request : '';

            $this->eventDispatcher->fire(
                new AddressErpCheckFailed($command, $request, $response, $e)
            );

            if (! $command->isSilent()) {
                throw $e;
            }

        }
    }

    public function updateShippingAddress(UpdateShippingAddressCommand $command)
    {
        try {

            $address = $this->addressTranslator->translate($command->getAddress());

            $request = $this->envelopeFactory->make($address, 'update');

            $response = $this->orderRepository->updateShippingAddress($address);

            if (! empty($addressId = $response->getAddressId())) {

                $command->getAddress()->setCode($addressId);

                $this->eventDispatcher->fire(
                    new ShippingAddressWasUpdated($command, $request, $response->getRaw())
                );

                return $response;
            }

            throw new ErpException('Error when updating order shipping address on erp.', $response);

        } catch (Exception $e) {

            $response = $e instanceof ErpException ? $e->getResponse()->getRaw() : '';

            $request = isset($request) ? $request : '';

            $this->eventDispatcher->fire(
                new ShippingAddressUpdateFailed($command, $request, $response, $e)
            );

            if (! $command->isSilent()) {
                throw $e;
            }

        }
    }

}
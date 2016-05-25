<?php

namespace Vinci\Domain\Order;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Customer\Address\AddressRepository;
use Vinci\Domain\Order\Address\Address;
use Vinci\Domain\Order\Factory\OrderFactory;
use Vinci\Domain\Order\Factory\OrderItemFactory;
use Illuminate\Contracts\Events\Dispatcher;

class OrderService
{

    protected $entityManager;

    protected $validator;

    protected $factory;

    protected $orderItemFactory;

    protected $addressRepository;

    protected $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderValidator $validator,
        OrderFactory $factory,
        OrderItemFactory $orderItemFactory,
        AddressRepository $addressRepository,
        Dispatcher $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->factory = $factory;
        $this->orderItemFactory = $orderItemFactory;
        $this->addressRepository = $addressRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->entityManager->transactional(function($em) use ($data) {

            $order = $this->factory->make();

            $shippingAddress = $this->getShippingAddress($data);
            $billingAddress = clone $shippingAddress;

            $order
                ->setShippingAddress($shippingAddress)
                ->setBillingAddress($billingAddress)
                ->setChannel(array_get($data, 'channel'))
                ->setCustomer(array_get($data, 'customer'));

            $this->addItems($order, $this->getOrderItems($data));

            $this->dispatchEvents($order);

            $em->persist($order);

            return $order;
        });
    }

    protected function dispatchEvents(OrderInterface $order)
    {
        foreach ($order->releaseEvents() as $event) {
            $this->eventDispatcher->fire($event);
        }
    }

    protected function addItems(OrderInterface $order, Collection $items)
    {
        foreach ($items as $item) {
            $order->addItem($item);
        }
    }

    protected function getShippingAddress(array $data)
    {
        $address = $this->addressRepository->getOneById(array_get($data, 'shipping.address'));
        $shippingAddress = new Address;
        $shippingAddress->override($address);
        return $shippingAddress;
    }

    protected function getOrderItems(array $data)
    {
        return $this->orderItemFactory->makeFromShoppingCart(array_get($data, 'cart'));
    }

}
<?php

namespace Vinci\Domain\Order\Factory;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Customer\Address\AddressRepository;
use Vinci\Domain\Order\Address\Address;
use Vinci\Domain\Order\Order;
use Vinci\Domain\Order\OrderInterface;

class OrderFactory
{

    private $entityManager;

    private $orderItemFactory;

    private $addressRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderItemFactory $orderItemFactory,
        AddressRepository $addressRepository
    ) {
        $this->entityManager = $entityManager;
        $this->orderItemFactory = $orderItemFactory;
        $this->addressRepository = $addressRepository;
    }

    public function make(array $data)
    {
        $order = $this->getNewInstance();

        list($shippingAddress, $billingAddress) = $this->getAddresses($data);

        $channel = $this->getChannel($data);
        $customer = $this->getCustomer($data);

        $order
            ->setShippingAddress($shippingAddress)
            ->setBillingAddress($billingAddress)
            ->setChannel($channel)
            ->setCustomer($customer);

        $this->addItems($order, $this->getOrderItems($data));

        return $order;
    }

    protected function addItems(OrderInterface $order, Collection $items)
    {
        foreach ($items as $item) {
            $order->addItem($item);
        }
    }

    protected function getOrderItems(array $data)
    {
        return $this->orderItemFactory->makeFromShoppingCart(array_get($data, 'cart'));
    }

    protected function getChannel($data)
    {
        return array_get($data, 'channel');
    }

    protected function getCustomer($data)
    {
        return array_get($data, 'customer');
    }

    private function getAddresses(array $data)
    {
        $address = $this->addressRepository->getOneById(array_get($data, 'shipping.address'));
        $shippingAddress = new Address;
        $shippingAddress->override($address);

        $billingAddress = clone $shippingAddress;

        return [$shippingAddress, $billingAddress];
    }

    protected function getNewInstance()
    {
        return new Order;
    }

}
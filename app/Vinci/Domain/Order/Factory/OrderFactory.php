<?php

namespace Vinci\Domain\Order\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Customer\Address\AddressRepository;
use Vinci\Domain\Order\Address\Address;
use Vinci\Domain\Order\Order;

class OrderFactory
{

    private $entityManager;

    private $addressRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        AddressRepository $addressRepository
    ) {
        $this->entityManager = $entityManager;
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

        return $order;
    }

    protected function getChannel($data)
    {
        return array_get($data, 'channel');
    }

    protected function getCustomer($data)
    {
        return array_get($data, 'customer');
    }

    protected function getShoppingCart(array $data)
    {
        return array_get($data, 'cart');
    }

    private function getAddresses(array $data)
    {
        $address = $this->addressRepository->getOneById(array_get($data, 'shipping.address'));
        $shippingAddress = new Address;
        $shippingAddress->override($address);

        $billingAddress = new Address;

        if (! empty($billAddress = $this->getCustomer($data)->getMainAddress())) {
            $billingAddress->override($billAddress);
        } else {
            $billingAddress = clone $shippingAddress;
        }

        return [$shippingAddress, $billingAddress];
    }

    protected function getNewInstance()
    {
        return new Order;
    }

}
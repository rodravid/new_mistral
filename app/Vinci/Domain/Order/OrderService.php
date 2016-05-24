<?php

namespace Vinci\Domain\Order;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Customer\Address\AddressRepository;
use Vinci\Domain\Order\Address\Address;

class OrderService
{

    protected $entityManager;

    protected $validator;

    protected $addressRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        OrderValidator $validator,
        AddressRepository $addressRepository
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->addressRepository = $addressRepository;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        $order = new Order();

        $shippingAddress = $this->getShippingAddress($data);
        $billingAddress = clone $shippingAddress;

        $order
            ->setShippingAddress($shippingAddress)
            ->setBillingAddress($billingAddress)
            ->setChannel(array_get($data, 'channel'))
            ->setCustomer(array_get($data, 'customer'));

        dd($order);

    }

    protected function getShippingAddress(array $data)
    {
        $address = $this->addressRepository->getOneById(array_get($data, 'shipping.address'));
        $shippingAddress = new Address;
        $shippingAddress->override($address);
        return $shippingAddress;
    }

}
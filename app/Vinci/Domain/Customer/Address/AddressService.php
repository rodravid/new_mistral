<?php

namespace Vinci\Domain\Customer\Address;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Core\Services\Sanitizer\Contracts\Sanitizer;
use Vinci\Domain\Address\MultiAddressValidator;
use Vinci\Domain\Customer\Customer;

class AddressService
{
    private $entityManager;

    private $addressFactory;

    private $addressValidator;

    private $sanitizer;

    public function __construct(
        EntityManagerInterface $entityManager,
        AddressFactory $addressFactory,
        MultiAddressValidator $addressValidator,
        Sanitizer $sanitizer
    )
    {
        $this->entityManager = $entityManager;
        $this->addressFactory = $addressFactory;
        $this->addressValidator = $addressValidator;
        $this->sanitizer = $sanitizer;
    }

    public function create(array $data, $customerId)
    {
        $this->sanitize($data['addresses']);
        $this->validate($data);

        return $this->saveAddress($data, $customerId, function($addressData) {
            return $this->addressFactory->makeFromArray($addressData);
        });
    }

    protected function saveAddress($data, $customerId,  Closure $method)
    {
        $address = $method($data['addresses'][0]);

        $address->setCustomer($this->entityManager->getReference(Customer::class, $customerId));

        $this->entityManager->persist($address);
        $this->entityManager->flush();

        return $address;
    }

    public function validate(array $data)
    {
        return $this->addressValidator->with($data)->passesOrFail();
    }

    public function sanitize(array &$addresses)
    {
        $sanitized = [];

        foreach ($addresses as &$address) {
            $sanitized[] = $this->sanitizeAddress($address);
        }

        return $sanitized;
    }

    public function hydrateCustomerAddresses(Customer $customer, $addresses, $mainAddressId)
    {

        $this->sanitize($addresses);

        $addressCollection = $this->addressFactory->makeCollectionFromArray($addresses);

        $customer->syncAddress($addressCollection);

        if (empty($mainAddressId)) {
            $mainAddress = $addressCollection->filter(function($address) {
                return ! $address->getId();
            })->first();

        } else {
            $mainAddress = $addressCollection->filter(function($address) use ($mainAddressId) {
                return $address->getId() == $mainAddressId;
            })->first();
        }

        $customer->setMainAddress($mainAddress);
    }

    protected function sanitizeAddress(array &$address)
    {
        $this->sanitizer->sanitize([
            'postal_code' => 'trim|only_numbers',
            'address' => 'trim|strtolower|ucwords'
        ], $address);

        return $address;
    }

}
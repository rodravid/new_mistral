<?php

namespace Vinci\Domain\Customer;

use Carbon\Carbon;
use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Core\Services\Sanitizer\Contracts\Sanitizer;
use Vinci\Domain\Customer\Address\AddressService;

class CustomerService
{
    private $repository;

    private $entityManager;

    private $validator;

    private $addressService;

    private $sanitizer;

    public function __construct(
        EntityManagerInterface $entityManager,
        CustomerRepository $repository,
        CustomerValidator $validator,
        AddressService $addressService,
        Sanitizer $sanitizer
    )
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->addressService = $addressService;
        $this->sanitizer = $sanitizer;
    }

    public function create(array $data)
    {
        $this->sanitizeData($data);

        $this->validator->with($data)->passesOrFail();

        $this->addressService->validate($data);

        return $this->saveCustomer($data, function() {
            return new Customer;
        });
    }

    public function update(array $data, $id)
    {
        $this->sanitizeData($data);

        $this->validator->with($data)->setId($id)->passesOrFail();

        $this->addressService->validate($data);

        return $this->saveCustomer($data, function() use ($id) {
            return $this->repository->find($id);
        });
    }

    protected function saveCustomer($data, Closure $method)
    {
        $customer = $method($data);

        $this->sanitizeData($data);

        $customer->setName($data['name'])
                 ->setEmail($data['email'])
                 ->setCustomerType($data['customerType'])
                 ->setPhone($data['phone'])
                 ->setCellPhone($data['cellPhone'])
                 ->setCommercialPhone($data['commercialPhone'])
                 ->setStatus($data['status']);

        if (! empty($data['password'])) {
            $customer->setPassword($data['password']);
        }

        if ($customer->isIndividual()) {

            $customer->setGender($data['gender'])
                     ->setBirthday(Carbon::createFromFormat('d/m/Y', $data['birthday']))
                     ->setCpf($data['cpf'])
                     ->setRg($data['rg']);

        } elseif ($customer->isCompany()) {

            $customer->setCompanyName($data['companyName'])
                     ->setCompanyContact($data['companyContact'])
                     ->setCnpj($data['cnpj'])
                     ->setStateRegistration($data['stateRegistration']);
        }

        if (isset($data['addresses'])) {
            $this->addressService->hydrateCustomerAddresses($customer, $data['addresses'], $data['main_address']);
        }


        $this->repository->save($customer);

        return $customer;
    }

    protected function sanitizeData(array &$data)
    {
        $this->sanitizer->sanitize([
            'name' => 'trim|strtolower|ucwords',
            'email' => 'trim|strtolower',
            'cpf' => 'trim|only_numbers',
            'rg' => 'trim|only_numbers',
            'issuingBody' => 'trim|strtoupper',
            'cnpj' => 'trim|only_numbers',
            'stateRegistration' => 'trim|only_numbers',
            'companyName' => 'trim|strtolower|ucwords',
            'companyContact' => 'trim|strtolower|ucwords',
            'phone' => 'trim|only_numbers',
            'cellPhone' => 'trim|only_numbers',
            'commercialPhone' => 'trim|only_numbers'
        ], $data);
    }

}
<?php

namespace Vinci\Domain\Customer;

use Carbon\Carbon;
use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\MessageBag;
use Vinci\App\Core\Services\Sanitizer\Contracts\Sanitizer;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Customer\Address\AddressService;
use Illuminate\Contracts\Events\Dispatcher as Event;
use Vinci\Domain\Customer\Events\CustomerWasCreated;
use Vinci\Domain\Customer\Events\CustomerWasUpdated;

class CustomerService
{
    private $repository;

    private $entityManager;

    private $validator;

    private $addressService;

    private $sanitizer;

    private $event;

    public function __construct(
        EntityManagerInterface $entityManager,
        CustomerRepository $repository,
        CustomerValidator $validator,
        AddressService $addressService,
        Sanitizer $sanitizer,
        Event $event
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->addressService = $addressService;
        $this->sanitizer = $sanitizer;
        $this->event = $event;
    }

    public function create(array $data)
    {
        $this->sanitizeData($data);

        $this->validate($data);

        return $this->saveCustomer($data, function() {
            return new Customer;
        });
    }

    public function update(array $data, $id)
    {
        $this->sanitizeData($data);

        $this->validator->with($data)->setId($id)->passesOrFail();

        if (isset($data['addresses'])) {
            $this->addressService->validate($data);
        }

        return $this->saveCustomer($data, function() use ($id) {
            return $this->repository->find($id);
        });
    }

    protected function saveCustomer($data, Closure $method)
    {
        $customer = $method($data);

        $this->sanitizeData($data);

        if (isset($data['importId']) && ! empty($data['importId'])) {
            $customer->setImportId($data['importId']);
        }

        $customer
            ->setEmail(array_get($data, 'email'))
            ->setCustomerType(array_get($data, 'customerType'))
            ->setPhone(array_get($data, 'phone'))
            ->setCellPhone(array_get($data, 'cellPhone'))
            ->setCommercialPhone(array_get($data, 'commercialPhone'))
            ->setStatus(array_get($data, 'status', 1));


        if (! empty($data['password'])) {
            $customer->setPassword($data['password']);
        }

        if ($customer->isIndividual()) {

            $customer
                ->setName($data['name'])
                ->setGender($data['gender'])
                ->setBirthday(Carbon::createFromFormat('d/m/Y', $data['birthday']))
                ->setCpf($data['cpf'])
                ->setRg($data['rg'])
                ->setIssuingBody($data['issuingBody']);

        } elseif ($customer->isCompany()) {

            $customer
                ->setName($data['companyName'])
                ->setCompanyName($data['companyName'])
                ->setCompanyContact($data['companyContact'])
                ->setCnpj($data['cnpj'])
                ->setStateRegistration($data['stateRegistration']);
        }

        $this->syncAddresses($customer, $data);

        $creating = empty($customer->getId());

        $this->repository->save($customer);

        if ($creating) {
            $this->event->fire(new CustomerWasCreated($customer->getId()));
        } else {
            $this->event->fire(new CustomerWasUpdated($customer->getId()));
        }

        return $customer;
    }

    protected function syncAddresses(Customer $customer, $data)
    {
        if (isset($data['addresses'])) {
            $this->addressService->hydrateCustomerAddresses($customer, $data['addresses'], $data['main_address']);
        }
    }

    protected function validate(array $data)
    {
        try {

            $this->validator->with($data)->passesOrFail();

        } catch (ValidationException $e) {

            $customerErrors = $e->getErrors()->messages();
            $addressesErrors = [];

            try {

                if (isset($data['addresses'])) {
                    $this->addressService->validate($data);
                }

            } catch (ValidationException $e) {
                $addressesErrors = $e->getErrors()->messages();
            }

            $messages = array_merge($customerErrors, $addressesErrors);

            $errors = new MessageBag($messages);

            throw new ValidationException($errors);
        }
    }

    protected function sanitizeData(array &$data)
    {
        $this->sanitizer->sanitize([
            'name' => 'trim|strtolower|ucwords',
            'email' => 'trim|strtolower',
            'cpf' => 'trim|only_numbers',
            'rg' => 'trim|only_alphanumeric',
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
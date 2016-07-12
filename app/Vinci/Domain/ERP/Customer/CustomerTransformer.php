<?php

namespace Vinci\Domain\ERP\Customer;

use League\Fractal\TransformerAbstract;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\ERP\Customer\Phone\PhoneTransformer;

class CustomerTransformer extends TransformerAbstract
{

    protected $defaultIncludes = [
        'phone',
        'cell_phone'
    ];

    public function transform(CustomerInterface $customer)
    {
        return [
            'name' => $customer->getName(),
            'contact_name' => $customer->getName(),
            'document' => $customer->getDocument(),
            'cpf' => $customer->getCustomerType() == 1 ? $customer->getCpf() : '',
            'rg' => $customer->getCustomerType() == 1 ? $customer->getRg() : '',
            'cnpj' => $customer->getCustomerType() == 2 ? $customer->getCnpj() : '',
            'person_type' => $customer->getCustomerType() == 1 ? 'F' : 'J',
            'person_code' => $customer->getCustomerType() == 1 ? 'F' : ''
        ];
    }

    public function includePhone(CustomerInterface $customer)
    {
        return $this->item($customer->getPhone(), new PhoneTransformer);
    }

    public function includeCellPhone(CustomerInterface $customer)
    {
        return $this->item($customer->getCellPhone(), new PhoneTransformer);
    }

}
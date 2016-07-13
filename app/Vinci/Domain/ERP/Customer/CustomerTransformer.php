<?php

namespace Vinci\Domain\ERP\Customer;

use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\ERP\Address\AddressTransformer;
use Vinci\Domain\ERP\Customer\Phone\PhoneTransformer;
use Vinci\Domain\ERP\Transformer\BaseTransformer;

class CustomerTransformer extends BaseTransformer
{

    protected $defaultIncludes = [
        'phone',
        'cell_phone',
        'address'
    ];

    public function transform(CustomerInterface $customer)
    {
        return [
            'name' => $this->normalizeString($customer->getName()),
            'email' => $customer->getEmail(),
            'contact_name' => $this->normalizeString($customer->getName()),
            'document' => $customer->getDocument(),
            'cpf' => $customer->getCustomerType() == 1 ? $customer->getCpf() : '',
            'rg' => $customer->getCustomerType() == 1 ? $customer->getRg() : '',
            'cnpj' => $customer->getCustomerType() == 2 ? $customer->getCnpj() : '',
            'person_type' => $customer->getCustomerType() == 1 ? 'F' : 'J',
            'person_code' => $customer->getCustomerType() == 1 ? 'F' : '',
            'obs' => $this->getObs($customer)
        ];
    }

    public function includeAddress(CustomerInterface $customer)
    {
        return $this->item($customer->getMainAddress(), new AddressTransformer);
    }

    public function includePhone(CustomerInterface $customer)
    {
        return $this->item($customer->getPhone(), new PhoneTransformer);
    }

    public function includeCellPhone(CustomerInterface $customer)
    {
        return $this->item($customer->getCellPhone(), new PhoneTransformer);
    }

    protected function getObs(CustomerInterface $customer)
    {
        if (! empty($landmark = $customer->getMainAddress()->getLandmark())) {
            return sprintf('REF. ENTREGA %s', $this->normalizeString($landmark));
        }

        return '';
    }

}
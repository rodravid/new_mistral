<?php

namespace Vinci\Domain\ERP\Customer\Commands;

use Vinci\Domain\Customer\CustomerInterface;

class SaveCustomerCommand
{

    private $customer;

    private $userActor;

    public function __construct(CustomerInterface $customer, $userActor = null)
    {
        $this->customer = $customer;

        if (empty($userActor)) {
            $userActor = $this->getDefaultUserActor();
        }

        $this->userActor = $userActor;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function getUserActor()
    {
        return $this->userActor;
    }

    protected function getDefaultUserActor()
    {
        return 'Sistema';
    }

}
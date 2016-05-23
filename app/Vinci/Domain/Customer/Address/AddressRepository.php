<?php

namespace Vinci\Domain\Customer\Address;

interface AddressRepository
{

    public function getAllByCustomer($customer);

    public function getOneById($id);

}
<?php

namespace Vinci\Domain\Payment\Repositories;


interface PaymentMethodsRepository
{

    public function getAll();

    public function findOneById($id);

}
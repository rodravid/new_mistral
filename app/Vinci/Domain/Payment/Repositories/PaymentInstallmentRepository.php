<?php

namespace Vinci\Domain\Payment\Repositories;


interface PaymentInstallmentRepository
{

    public function getInstallmentQuantityBy($amount, $paymentMethod);

}
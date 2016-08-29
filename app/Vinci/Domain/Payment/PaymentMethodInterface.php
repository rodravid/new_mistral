<?php

namespace Vinci\Domain\Payment;

interface PaymentMethodInterface
{

    const CREDIT_CARD = 'credit_card';
    const BANK_DEPOSIT = 'account_deposit';

    public function getName();

    public function setName($name);

    public function getDescription();

    public function setDescription($description);

    public function getGateway();

    public function setGateway($gateway);

    public function getStatus();

    public function setStatus($status);

}
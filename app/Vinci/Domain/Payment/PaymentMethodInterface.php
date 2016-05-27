<?php

namespace Vinci\Domain\Payment;

interface PaymentMethodInterface
{

    public function getName();

    public function setName($name);

    public function getDescription();

    public function setDescription($description);

    public function getGateway();

    public function setGateway($gateway);

}
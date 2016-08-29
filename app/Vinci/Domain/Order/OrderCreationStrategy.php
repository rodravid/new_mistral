<?php

namespace Vinci\Domain\Order;

interface OrderCreationStrategy
{

    public function execute(array $data);

}
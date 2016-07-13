<?php

namespace Vinci\Infrastructure\ERP\Order;

use Illuminate\Contracts\Config\Repository;
use Vinci\Domain\ERP\Order\OrderRepository;
use Vinci\Infrastructure\ERP\BaseERPRepository;

class OrderRepositoryERP extends BaseERPRepository implements OrderRepository
{
    public function __construct(Repository $config)
    {
        parent::__construct($config);
    }

    

}
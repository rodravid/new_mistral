<?php

namespace Vinci\Domain\Order\Creation\Steps;

use Vinci\Domain\Order\Factory\OrderFactory;

class MakeOrderInstance
{
    private $factory;

    public function __construct(OrderFactory $factory)
    {
        $this->factory = $factory;
    }

    public function handle($data, $next)
    {
        $order = $this->factory->make($data);

        $data['order'] = $order;

        return $next($data);
    }

}
<?php

namespace Vinci\Domain\Order\Creation\Steps;

class SendOrderObjectToService
{

    public function handle($data, $next)
    {
        return $next($data['order']);
    }

}
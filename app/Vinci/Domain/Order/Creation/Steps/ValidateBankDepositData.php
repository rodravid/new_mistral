<?php

namespace Vinci\Domain\Order\Creation\Steps;

class ValidateBankDepositData
{
    public function handle($data, $next)
    {
        return $next($data);
    }
}
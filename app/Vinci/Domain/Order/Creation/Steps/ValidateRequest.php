<?php

namespace Vinci\Domain\Order\Creation\Steps;

use Vinci\Domain\Order\Validators\OrderValidator;

class ValidateRequest
{
    private $validator;

    public function __construct(OrderValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle($data, $next)
    {
        $this->validator->with($data)->passesOrFail();

        return $next($data);
    }

}
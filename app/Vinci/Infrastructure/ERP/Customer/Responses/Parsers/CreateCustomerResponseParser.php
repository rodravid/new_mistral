<?php

namespace Vinci\Infrastructure\ERP\Customer\Responses\Parsers;

use Exception;
use Vinci\Infrastructure\ERP\Customer\Responses\CreateCustomerResponse;
use Vinci\Infrastructure\ERP\ResponseParser;

class CreateCustomerResponseParser extends ResponseParser
{
    public function parseResponse($response)
    {
        try {

            $message = $this->extractMessage($response);

            return new CreateCustomerResponse($response, $message);

        } catch (Exception $e)  {

            return new CreateCustomerResponse($response, '');
        }
    }

}
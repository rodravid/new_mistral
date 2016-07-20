<?php

namespace Vinci\Infrastructure\ERP\Order\Responses\Parsers;

use Exception;
use Vinci\Infrastructure\ERP\Order\Responses\CreateOrderResponse;
use Vinci\Infrastructure\ERP\ResponseParser;

class CreateOrderResponseParser extends ResponseParser
{
    public function parseResponse($response)
    {
        try {

            $orderId = $this->extractOrderId($response);

            return new CreateOrderResponse($response, $orderId);

        } catch (Exception $e)  {

            return new CreateOrderResponse($response);
        }
    }

    protected function extractOrderId($response)
    {
        return trim((string) simplexml_load_string($this->sanitizeResponse($response))->PIDPED);
    }

}
<?php

namespace Vinci\Infrastructure\ERP\Order\Responses\Parsers;

use Exception;
use Vinci\Infrastructure\ERP\Order\Responses\CreateOrderItemResponse;
use Vinci\Infrastructure\ERP\ResponseParser;

class CreateOrderItemResponseParser extends ResponseParser
{
    public function parseResponse($response)
    {
        try {

            $message = $this->extractMessage($response);

            return new CreateOrderItemResponse($response, $message);

        } catch (Exception $e)  {

            return new CreateOrderItemResponse($response);
        }
    }

    protected function extractMessage($response)
    {
        return trim((string) simplexml_load_string($this->sanitizeResponse($response))->PVMSG);
    }

}
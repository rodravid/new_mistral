<?php

namespace Vinci\Infrastructure\Services\Postmon;

use Exception;
use GuzzleHttp\Client;

class Postmon
{

    public function getAddress($cep)
    {
        try {

            $cep = only_numbers($cep);

            $url = "http://api.postmon.com.br/v1/cep/" . $cep;

            $client = new Client;

            $response = $client->get($url)->getBody()->getContents();

            return json_decode($response, true);

        } catch (Exception $e) {
            throw $e;
        }

    }

}
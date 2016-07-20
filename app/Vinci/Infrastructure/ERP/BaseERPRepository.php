<?php

namespace Vinci\Infrastructure\ERP;

use Exception;
use Illuminate\Contracts\Config\Repository;
use Spatie\Fractal\Fractal;
use Vinci\Infrastructure\Exceptions\EmptyResponseException;

abstract class BaseErpRepository
{
    protected $config;

    protected $fractal;

    public function __construct(Repository $config, Fractal $fractal)
    {
        $this->config = $config;
        $this->fractal = $fractal;
    }

    protected function buildClient($wsdlKey, array $config = [])
    {
        $config = array_merge([
            'login' => $this->config['erp.username'],
            'password' => $this->config['erp.password'],
            'trace' => true,
            'cache_wsdl' => WSDL_CACHE_NONE
        ], $config);

        return new CustomSoapClient($this->getWsdl($wsdlKey) . '?wsdl', $config);
    }

    public function getWsdl($configKey)
    {
        $fullKey = sprintf('erp.wsdl.%s', $configKey);

        if (! $this->config->has($fullKey)) {
            throw new Exception(sprintf('The wsdl config key %s does not exists.', $fullKey));
        }

        return $this->config->get($fullKey);
    }

    public function getStoreCode()
    {
        return $this->config->get('erp.products_price_list');
    }

    protected function parseResponse($response, $includeRoot = false)
    {
        if (isset($response->PXML->any)) {
            $response = $response->PXML->any;
        } else {
            throw new EmptyResponseException('Empty response.');
        }

        if ($includeRoot) {
            $response = sprintf('<data>%s</data>', $response);
        }

        $response = simplexml_load_string($response);

        if(isset($response->ERRO)) {
            throw new IntegrationException($response->ERRO);
        }

        if(isset($response->PERRO)) {
            throw new IntegrationException($response->PERRO);
        }

        return $response;
    }

}
<?php

namespace Vinci\Infrastructure\ERP;

use Exception;
use Illuminate\Contracts\Config\Repository;

abstract class BaseERPRepository
{
    protected $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    protected function buildClient($wsdlKey, array $config = [])
    {
        $config = array_merge([
            'login' => $this->config['erp.username'],
            'password' => $this->config['erp.password'],
            'trace' => true,
            'cache_wsdl' => WSDL_CACHE_NONE
        ], $config);

        return new CustomSoapClient($this->getWsdl($wsdlKey), $config);
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

}
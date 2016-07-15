<?php

namespace Vinci\Infrastructure\ERP\Customer;

use GuzzleHttp\Client;
use Illuminate\Contracts\Config\Repository;
use Spatie\Fractal\Fractal;
use View;
use Vinci\Domain\ERP\Customer\Customer;
use Vinci\Domain\ERP\Customer\CustomerErpTransformer;
use Vinci\Domain\ERP\Customer\CustomerRepository;
use Vinci\Infrastructure\ERP\BaseERPRepository;

class CustomerRepositoryERP extends BaseERPRepository implements CustomerRepository
{

    protected $fractal;

    public function __construct(Repository $config, Fractal $fractal)
    {
        parent::__construct($config);

        $this->fractal = $fractal;
    }

    public function create(Customer $customer)
    {
        $input = $this->getCustomerInput($customer);

        $body = View::make('erp::envelopes.customer.create', compact('input'))->render();

        $response = $this->request('http://amzt.gestaoweb.com.br:18080/orawsv/WSGW/CRIAPESSOA', $body);

        $xml = $response->getBody()->getContents();

        dd($xml);

        try {

            $client = $this->buildClient('customers.create_customer');

            $response = $client->call('CRIAPESSOA', [
                'CRIAPESSOAInput' => $this->getCustomerInput($customer)
            ]);

            dd($response);

            $customerId = $this->parseResponse($response);

            dd($customerId);

            return trim($customerId);

        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function getCustomerInput(Customer $customer)
    {
        return $this->fractal
            ->item($customer)
            ->transformWith(new CustomerErpTransformer)
            ->toArray();
    }

    protected function request($url, $body, $type = 'POST', $options = [])
    {
        $defaults = [
            'headers' => [
                'Cache-Control' => 'no-cache',
                'Pragma' => 'no-cache'
            ],
            'auth' => [$this->config['erp.username'], $this->config['erp.password']],
            'body' => $body
        ];

        $options = array_merge($defaults, $options);

        return $this->http->request($type, $url, $options);
    }

    protected function parseResponse($response, $includeRoot = false)
    {
        return (string) $response->PMSG;
    }

}
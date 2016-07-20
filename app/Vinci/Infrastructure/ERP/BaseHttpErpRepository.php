<?php

namespace Vinci\Infrastructure\ERP;

use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Contracts\Config\Repository;
use Spatie\Fractal\Fractal;

abstract class BaseHttpErpRepository extends BaseErpRepository
{

    protected $http;

    protected $envelopeFactory;

    public function __construct(
        Repository $config,
        Fractal $fractal,
        EnvelopeFactory $envelopeFactory
    ) {
        parent::__construct($config, $fractal);

        $this->http = new GuzzleClient;
        $this->envelopeFactory = $envelopeFactory;
    }

    protected function erpRequest($url, $body, $parser = null, $type = 'POST', $options = [])
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

        $response = $this->http->request($type, $url, $options);

        return $this->parseHttpResponse($response, $parser);
    }

    protected function parseHttpResponse($response, $parser = null)
    {
        if (empty($parser)) {
            return $response;
        }

        return app($parser)->parse($response);
    }

    public function getResponseParsers()
    {
        return [
            $this->config['erp.w']
        ];
    }

}
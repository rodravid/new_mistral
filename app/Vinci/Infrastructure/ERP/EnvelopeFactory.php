<?php

namespace Vinci\Infrastructure\ERP;

use Exception;
use Illuminate\Contracts\View\Factory;
use Spatie\Fractal\Fractal;
use Vinci\Domain\ERP\Customer\Customer;
use Vinci\Domain\ERP\Customer\CustomerErpTransformer;

class EnvelopeFactory
{

    private $view;

    private $fractal;

    public function __construct(Factory $view, Fractal $fractal)
    {
        $this->view = $view;
        $this->fractal = $fractal;
    }

    protected $viewNamespace = 'erp::envelopes';

    protected $mappings = [
        Customer::class => [
            'create' => [
                'envelope' => 'customer.create',
                'transformer' => CustomerErpTransformer::class
            ]
        ]
    ];

    public function make($model, $type)
    {
        $mapping = $this->getMapping($model, $type);

        $data = $this->parseData($model, $mapping);

        return $this->view->make($this->parseEnvelopeName($mapping), compact('data'))->render();
    }

    protected function parseData($model, array $mapping)
    {
        if (isset($mapping['transformer']) && ! empty($mapping['transformer'])) {

            return $this->fractal
                ->item($model)
                ->transformWith(new $mapping['transformer'])
                ->toArray();
        }

        return $model;
    }

    protected function parseEnvelopeName(array $mapping)
    {
        if (! isset($mapping['envelope'])) {
            throw new Exception(sprintf('Envelope not defined: %s', $mapping['envelope']));
        }

        return sprintf('%s.%s', $this->viewNamespace, $mapping['envelope']);
    }

    protected function getMapping($model, $type)
    {
        $class = get_class($model);

        if (! isset($this->mappings[$class][$type])) {
            throw new Exception(sprintf('Envelope mapping not found for class %s and type %s.', $class, $type));
        }

        return $this->mappings[$class][$type];
    }

}
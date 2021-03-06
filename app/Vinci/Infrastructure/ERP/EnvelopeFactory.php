<?php

namespace Vinci\Infrastructure\ERP;

use Exception;
use Illuminate\Contracts\View\Factory;
use Spatie\Fractal\Fractal;
use Vinci\Domain\ERP\Address\Address;
use Vinci\Domain\ERP\Customer\Customer;
use Vinci\Domain\ERP\Customer\CustomerErpTransformer;
use Vinci\Domain\ERP\Order\Item\Item;
use Vinci\Domain\ERP\Order\Item\ItemErpTransformer;
use Vinci\Domain\ERP\Order\Order;
use Vinci\Domain\ERP\Order\OrderErpTransformer;
use Vinci\Domain\ERP\Order\Shipping\AddressErpTransformer;
use Vinci\Domain\ERP\Order\Shipping\AddressGetErpTransformer;

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
        ],
        Order::class => [
            'create' => [
                'envelope' => 'order.create',
                'transformer' => OrderErpTransformer::class
            ]
        ],
        Item::class => [
            'create' => [
                'envelope' => 'order.item.create',
                'transformer' => ItemErpTransformer::class
            ]
        ],
        Address::class => [
            'update' => [
                'envelope' => 'customer.shipping.address.update',
                'transformer' => AddressErpTransformer::class
            ],
            'get' => [
                'envelope' => 'customer.shipping.address.get',
                'transformer' => AddressGetErpTransformer::class
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
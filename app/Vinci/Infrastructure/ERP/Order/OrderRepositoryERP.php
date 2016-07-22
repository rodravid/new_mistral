<?php

namespace Vinci\Infrastructure\ERP\Order;

use Vinci\Domain\ERP\Address\Address;
use Vinci\Domain\ERP\Order\Item\Item;
use Vinci\Domain\ERP\Order\Order;
use Vinci\Domain\ERP\Order\OrderRepository;
use Vinci\Infrastructure\ERP\BaseHttpErpRepository;
use Vinci\Infrastructure\ERP\Order\Responses\Parsers\CreateOrderItemResponseParser;
use Vinci\Infrastructure\ERP\Order\Responses\Parsers\CreateOrderResponseParser;
use Vinci\Infrastructure\ERP\Order\Responses\Parsers\GetShippingAddressResponseParser;
use Vinci\Infrastructure\ERP\Order\Responses\Parsers\UpdateShippingAddressResponseParser;

class OrderRepositoryERP extends BaseHttpErpRepository implements OrderRepository
{
    public function create(Order $order)
    {
        return $this->erpRequest(
            $this->config->get('erp.wsdl.orders.create_order'),
            $this->envelopeFactory->make($order, 'create'),
            CreateOrderResponseParser::class
        );
    }

    public function createItem(Item $item)
    {
        return $this->erpRequest(
            $this->config->get('erp.wsdl.orders.create_order_item'),
            $this->envelopeFactory->make($item, 'create'),
            CreateOrderItemResponseParser::class
        );
    }

    public function getShippingAddressId(Address $address)
    {
        return $this->erpRequest(
            $this->config->get('erp.wsdl.customers.get_shipping_address'),
            $this->envelopeFactory->make($address, 'get'),
            GetShippingAddressResponseParser::class
        );
    }

    public function updateShippingAddress(Address $address)
    {
        return $this->erpRequest(
            $this->config->get('erp.wsdl.customers.update_shipping_address'),
            $this->envelopeFactory->make($address, 'update'),
            UpdateShippingAddressResponseParser::class
        );
    }
}
@extends('cms::integration.logs.default')

@section('log.title', 'ERP - Log de integração de items de pedidos')

@section('log.header')
    <small><b>Pedido:</b> <a href="{{ route('cms.orders.show', $log->getItem()->getOrder()->getId()) }}" target="_blank">#{{ $log->getItem()->getOrder()->getNumber() }}</a></small>
    <small><b>Item:</b> #{{ $log->getItem()->getId() }}</small>
    <small><b>SKU:</b> <a href="{{ route('cms.products.edit', $log->getItem()->getProductVariant()->getId()) }}" target="_blank">#{{ $log->getItem()->getProductVariant()->getSku() }}</a></small>
@endsection

@extends('cms::integration.logs.default')

@section('log.title', 'ERP - Log de integração de endereço de entrega de pedidos')

@section('log.header')
    <small><b>Pedido:</b> <a href="{{ route('cms.orders.show', $log->getOrder()->getId()) }}" target="_blank">#{{ $log->getOrder()->getNumber() }}</a></small>
@endsection

@extends('cms::integration.logs.default')

@section('log.title', 'ERP - Log de integração de pedidos')

@section('log.header')
    <small>Pedido: <a href="{{ route('cms.orders.show', $log->getOrder()->getId()) }}" target="_blank">#{{ $log->getOrder()->getNumber() }}</a></small>
    <small>Status: {!! $log->present()->status_html !!}</small>
@endsection

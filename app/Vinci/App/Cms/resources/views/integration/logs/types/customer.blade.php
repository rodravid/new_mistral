@extends('cms::integration.logs.default')

@section('log.title', 'ERP - Log de integração de clientes')

@section('log.header')
    <small>Cliente: <a href="{{ route('cms.customers.show', $log->getCustomer()->getId()) }}" target="_blank">#{{ $log->getCustomer()->getId() }} - {{ $log->getCustomer()->getName() }}</a></small>
    <small>Status: {!! $log->present()->status_html !!}</small>
@endsection
@extends('cms::integration.logs.default')

@section('log.title', 'ERP - Log de integração de clientes')

@section('log.header')
    <small><b>Cliente:</b> <a href="{{ route('cms.customers.show', $log->getCustomer()->getId()) }}" target="_blank">#{{ $log->getCustomer()->getId() }} - {{ $log->getCustomer()->getName() }}</a></small>
@endsection
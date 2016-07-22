@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-eye"></i> Visualizando pedido #{{ $order->getNumber() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> Pedido #{{ $order->number }}
                            <small><b>Status:</b> {{ $order->status }}</small>
                            <small><b>Status da integração:</b> {!! $order->integration_status_html !!}</small>
                            @if(! empty($order->erp_number))
                                <small><b>Número no ERP:</b> {!! $order->erp_number !!}</small>
                            @endif
                            <small class="pull-right">Data: {{ $order->creation_date }}</small>
                            <small class="pull-right bt-print" style="margin-right: 10px; cursor: pointer;" onClick="window.print()"> <i class="fa fa-print"></i> Imprimir</small>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="box-body">
                @include('cms::orders.partials.info')

                @if ($loggedUser->hasPermissionTo('cms.orders.edit'))
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a href="{{ route($currentModule->getEditRouteName(), $order->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</a>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </section>

@endsection
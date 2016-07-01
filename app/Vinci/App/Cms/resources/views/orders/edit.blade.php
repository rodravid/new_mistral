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

        <div class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> Pedido #{{ $order->number }} <small>{{ $order->status }}</small>
                            <small class="pull-right">Data: {{ $order->creation_date }}</small>
                        </h2>
                    </div>
                </div>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                @include('cms::orders.partials.info')
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        {!! Form::open(['route' => ['cms.orders.edit#change-status', $order->getId()], 'method' => 'PUT', 'id' => 'frmChangeOrderStatus']) !!}
                            @include('cms::orders.form.status')
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection
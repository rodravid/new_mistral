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
                            <small id="print" class="pull-right bt-print" style="margin-right: 10px; cursor: pointer;"> <i class="fa fa-print"></i> Imprimir</small>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="box-body">
                @include('cms::orders.partials.info')

                <div class="row no-print">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="btn-group" style="margin-bottom: 20px;">
                                    @if ($loggedUser->hasPermissionTo('cms.orders.edit'))
                                        <a href="{{ route($currentModule->getEditRouteName(), $order->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</a>
                                    @endif
                                    @if($order->hasProperty('erpIntegrationStatus') && ! $order->wasIntegrated())
                                        <a href="javascript:void(0);" class="btn btn-info"
                                           data-form-link
                                           data-confirm-title="Confirmação de alteração"
                                           data-confirm-text="Deseja realmente alterar o status de integração?"
                                           data-method="PUT"
                                           data-action="{{ route('cms.integration.setAsIntegrated', ['entity' => get_class($order->getObject()),'id' => $order->id]) }}"><i class="fa fa-check"></i> Definir como integrado</a>
                                    @endif
                                    @if ($loggedUser->isSuperAdmin())
                                        <a href="javascript:void(0);" class="btn btn-success"
                                           data-form-link
                                           data-confirm-title="Confirmação de envio"
                                           data-confirm-text="Deseja realmente enviar o pedido para a fila de integração? <b>Obs:</b> O cliente também será enviado."
                                           data-method="POST"
                                           data-action="{{ route('cms.orders.edit#export-erp-queue', [$order->getId()]) }}"><i class="glyphicon glyphicon-export"></i> Enviar para fila de integração</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row no-print">
            <div class="col-xs-12">
                @include('cms::integration.logs.box', [
                    'boxTitle' => 'Log de integração do pedido com o ERP'
                ])
            </div>
            <div class="col-xs-12">
                @include('cms::integration.logs.box', [
                    'boxTitle' => 'Log de integração dos items do pedido com o ERP',
                    'integrationLogs' => $integrationLogsItems
                ])
            </div>
            <div class="col-xs-12">
                @include('cms::integration.logs.box', [
                    'boxTitle' => 'Log de integração do endereço de entrega com o ERP',
                    'with' => ['request_type' => true],
                    'integrationLogs' => $integrationLogsAddress
                ])
            </div>
        </div>
    </section>

@endsection

@section ('scripts')
    @parent
    <script>
        $("#print").click(function () {
            window.print();
            $.ajax({
                url: '{{ route('cms.orders.printed', ['order' => $order->id]) }}',
                type: 'POST'
            });
        });
    </script>
@endsection
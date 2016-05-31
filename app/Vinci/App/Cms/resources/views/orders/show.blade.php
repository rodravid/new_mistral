@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-eye"></i> Visualizando cliente #{{ $order->getId() }}</li>
    </ol>
@endsection

@section('module.content')


    <section class="content">
        <div class="box box-primary">
            <div class="box-body">

                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> Pedido #{{ $order->number }}.
                            <small class="pull-right">Data: {{ $order->creation_date }}</small>
                        </h2>
                    </div>
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-3 invoice-col">
                        <strong>Cliente</strong>
                        <address>
                            <a href="{{ route('cms.customers.show', $order->customer->id) }}" target="_blank"><strong>{{ $order->customer->name }}</strong></a><br>
                            Telefone: {{ $order->customer->phone }}<br>
                            Email: {{ $order->customer->email }}
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <strong>Endereço de cobrança</strong>
                        <address>
                            {!! $order->billingAddress->address_html !!}
                        </address>
                    </div>
                    <div class="col-sm-3 invoice-col">
                        <strong>Endereço de entrega</strong>
                        <address>
                            {!! $order->shippingAddress->address_html !!}
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-3 invoice-col">
                        <b>Número do pedido:</b> {{ $order->number }}<br>
                        <b>Realizado em:</b> {{ $order->created_at }}<br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>#SKU</th>
                                <th>Produto</th>
                                <th>Quantidade</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($order->getItems() as $item)
                                <tr>
                                    <td>{{ $item->product->sku }}</td>
                                    <td>{{ $item->product->title }}</td>
                                    <td>{{ $item->quantity_units }}</td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-xs-6">
                        <p class="lead">Forma de pagamento:</p>
                        <img src="/assets/cms/dist/img/credit/visa.png" alt="Visa">

                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                            <strong>{{ $order->payment->installment_text }}</strong><br /><br >
                            <strong>Titular do cartão:</strong> {{ $order->payment->credit_card->holdername }}<br >
                            <strong>Número:</strong> {{ $order->payment->credit_card->number }}<br >
                            <strong>Data de expiração:</strong> {{ $order->payment->credit_card->expiry_date }}<br >
                            <strong>Código de segurança:</strong> {{ $order->payment->credit_card->securityCode }}<br >
                        </p>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-6">

                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th style="width:50%">Total dos items:</th>
                                    <td>{{ $order->items_total }}</td>
                                </tr>
                                <tr>
                                    <th>Frete:</th>
                                    <td>{{ $order->shipment->amount }}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>{{ $order->total }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                {{--<div class="row no-print">--}}
                    {{--<div class="col-xs-12">--}}
                        {{--<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>--}}
                    {{--</div>--}}
                {{--</div>--}}

            </div>
        </div>

    </section>

@endsection
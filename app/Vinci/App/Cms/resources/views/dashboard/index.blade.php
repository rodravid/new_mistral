@extends('cms::layouts.master')

@section('content')

    <section class="content-header">
        <h1>Dashboard<small>Painel de Controle</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('cms.dashboard.show') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            @if ($loggedUser->canManageModule('orders'))
                <div class="col-lg-3 col-xs-6">
                    <a href="{{ route('cms.orders.list') }}" class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $totalOrders }}</h3>
                            <p>Pedidos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <label class="small-box-footer" style="cursor:pointer;">
                            Mais informações <i class="fa fa-arrow-circle-right"></i>
                        </label>
                    </a>
                </div>
            @endif
            @if ($loggedUser->canManageModule('products'))
                <div class="col-lg-3 col-xs-6">
                    <a href="{{ route('cms.products.list') }}" class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $totalProducts }}</h3>
                            <p>Produtos</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-cubes"></i>
                        </div>
                        <label class="small-box-footer" style="cursor:pointer;">
                            Mais informações <i class="fa fa-arrow-circle-right"></i>
                        </label>
                    </a>
                </div>
            @endif
            @if ($loggedUser->canManageModule('customers'))
                <div class="col-lg-3 col-xs-6">
                    <a href="{{ route('cms.customers.list') }}" class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $totalCustomers }}</h3>
                            <p>Clientes</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <label class="small-box-footer" style="cursor:pointer;">
                            Mais informações <i class="fa fa-arrow-circle-right"></i>
                        </label>
                    </a>
                </div>
            @endif
            @if ($loggedUser->canManageModule('newsletter'))
                <div class="col-lg-3 col-xs-6">
                    <a href="{{ route('cms.newsletter.list') }}" class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $totalNewsletters }}</h3>
                            <p>Assinantes newsletter</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-newspaper-o"></i>
                        </div>
                        <label class="small-box-footer" style="cursor:pointer;">
                            Mais informações <i class="fa fa-arrow-circle-right"></i>
                        </label>
                    </a>
                </div>
            @endif
        </div>
        <div class="row">
            <section class="col-lg-12">
                @if ($loggedUser->canManageModule('orders'))
                    <div id="OrdersLineChart" class="box box-solid bg-teal-gradient">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-shopping-bag"></i> Gráfico de vendas
                                <small>/ Totais diários (últimos 10 dias)</small>
                            </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-teal btn-sm" data-widget="remove">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body border-radius-none">
                            <div class="chart tab-pane" id="line-chart" style="height: 250px;width: 100%;"></div>
                        </div>
                    </div>
                @endif
            </section>
            <section class="col-lg-12">
                <div class="row">
                    <div id="left-column" class="col-lg-7 connectedSortable">
                        @if ($loggedUser->canManageModule('orders'))
                            <div id="ordersBarsChart" class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li class="active"><a href="#revenue-chart" data-toggle="tab">Área</a></li>
                                    <li class="pull-left">
                                        <a href="{{ route('cms.orders.list') }}">
                                            <h3 class="box-title">
                                                <i class="fa fa-th"></i> Gráfico de vendas
                                                <small>/ Totais detalhados (últimos 10 dias)</small>
                                            </h3>
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content no-padding">
                                    <div class="chart tab-pane active" id="bar-chart" style="position: relative; height: 300px;"></div>
                                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                                </div>
                                <div class="box-footer no-border">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <input type="text" class="knob" data-readonly="true" data-min="0"
                                                   data-max="{{ $totalOrdersOfLastDays }}"
                                                   value="{{ $totalWaitingPaymentOrdersOfLastDays }}" data-width="60"
                                                   data-height="60" data-fgColor="#a0d0e0">

                                            <div class="knob-label">Aguardando Pagamento</div>
                                        </div>
                                        <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                            <input type="text" class="knob" data-readonly="true" data-min="0"
                                                   data-max="{{ $totalOrdersOfLastDays }}"
                                                   value="{{ $totalPaidOrdersOfLastDays }}" data-width="60" data-height="60"
                                                   data-fgColor="#3c8dbc">

                                            <div class="knob-label">Pedidos Pagos</div>
                                        </div>
                                        <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                                            <input type="text" class="knob" data-readonly="true" data-min="0"
                                                   data-max="{{ $totalOrdersOfLastDays }}"
                                                   value="{{ $totalCompletedOrdersOfLastDays }}" data-width="60"
                                                   data-height="60" data-fgColor="#4da74d">

                                            <div class="knob-label">Pedidos Concluídos</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if ($loggedUser->canManageModule('orders'))
                            <div id="lastOrders" class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Últimos pedidos</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @if($lastOrders->count())
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <table class="table no-margin">
                                                <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Número do pedido</th>
                                                    <th>Cliente</th>
                                                    <th>Total</th>
                                                    <th width="15%">Status da integração</th>
                                                    <th>Data</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($lastOrders as $order)
                                                    <tr>
                                                        <td>
                                                            <a href="{{ route('cms.orders.show', $order->id) }}">
                                                                {{ $order->id }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $order->number }}</td>
                                                        <td>{{ $order->customer->name }}</td>
                                                        <td>{{ $order->total }}</td>
                                                        <td>{!! $order->integration_status_html !!}</td>
                                                        <td>
                                                            <div class="sparkbar" data-color="#00a65a" data-height="20">
                                                                {{ $order->created_at }}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="box-footer clearfix">
                                        <a href="{{ route('cms.orders.list') }}"
                                           class="btn btn-sm btn-info btn-flat pull-right">
                                            Ver todos
                                        </a>
                                    </div>
                                @else
                                    <div class="box-body text-center">Nenhum pedido encontrado.</div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div id="right-column" class="col-lg-5 connectedSortable">
                        @if ($loggedUser->canManageModule('products'))
                            <div id="productsRecentlyAdded" class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Produtos adicionados recentemente</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                @if($lastProductsAdded->count())
                                    <div class="box-body">
                                        <ul class="products-list product-list-in-box">
                                            @foreach ($lastProductsAdded as $product)
                                                <li class="item">
                                                    <div class="product-img">
                                                        <img src="{{ $product->image_url }}" alt="{{ $product->title }}">
                                                    </div>
                                                    <div class="product-info" style="margin-top: 15px">
                                                        <a href="{{ route('cms.products.edit', $product->id) }}"
                                                           class="product-title">
                                                            {{ $product->title }}
                                                        </a>
                                                         <span class="product-description">
                                                            @if ($product->hasProducer())
                                                                 {{ $product->producer->name }}<br>
                                                             @endif
                                                             Em estoque: {{ $product->stock }}<br>
                                                            <span class="label label-info">
                                                                {{ $product->sale_price }}
                                                            </span>
                                                        </span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="box-footer text-center">
                                        <a href="{{ route('cms.products.list') }}" class="uppercase">Todos</a>
                                    </div>
                                @else
                                    <div class="box-body text-center">Nenhum produto encontrado.</div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </section>

@endsection

@section('scripts')
    @parent

    <script src="{{ asset_cms('dist/js/pages/dashboard.js') }}"></script>

@endsection
@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        @if($currentModule->hasParent())
            <li><i class="{{ $currentModule->getParent()->getIcon() }}"></i> {{ $currentModule->getParent()->getTitle() }}</li>
        @endif
        <li class="active">{{ $currentModule->getTitle() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="col-xs-12">
                            <h4>Filtros</h4>
                            {!! Form::open(['id' => 'filters', 'route'=> 'cms.orders.list', 'method' => 'get']) !!}
                                <div class="row">
                                    <div class="form-group col-md-12 col-lg-3">
                                        <label for="dtpDateStart">Inicio</label>
                                        <div class="input-group date" id="startDatePicker">
                                            {!! Form::text('startDate', $filters['startDate'], ['data-date-format' => 'DD/MM/YYYY 00:00:00', 'class' => 'form-control']) !!}
                                            <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-lg-3">
                                        <label for="dtpDateStop">Termino</label>
                                        <div class="input-group date" id="endDatePicker">
                                            {!! Form::text('endAt', $filters['endAt'], ['data-date-format' => 'DD/MM/YYYY 23:59:59', 'class' => 'form-control']) !!}
                                            <span class="input-group-addon"><span class="glyphicon-calendar glyphicon"></span></span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-6">
                                        {!! Form::select('orderStatus', $orderStatuses, $filters['orderStatus'], ['class' => 'form-control', 'style' => 'margin-top: 25px;']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-5 col-lg-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                            {!! Form::text('keyword', $filters['keyword'], ['class' => 'form-control', 'placeholder' => 'Procure pelo ID, Número ou Cliente']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2 col-lg-3">
                                        {!! Form::select('itemsPerPage', [5 => '5 pedidos por página',
                                                                          10 => '10 pedidos por página',
                                                                          15 => '15 pedidos por página',
                                                                          20 => '20 pedidos por página',
                                                                          50 => '50 pedidos por página',
                                                                          100 => '100 pedidos por página'],
                                                          $filters['itemsPerPage'],
                                                          ['class' => 'form-control', 'id' => 'itemsPerPage']) !!}
                                    </div>
                                    <div class="form-group col-md-5 col-lg-3">
                                        <div class="btn-group">
                                            {!! Form::button('<i class="fa fa-search"></i> Procurar', ['class' => 'btn btn-info', 'type' => 'submit']) !!}
                                            <a href="{{ route('cms.orders.excel') }}" class="btn btn-success">
                                                <i class="fa fa-line-chart"></i> Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" data-url="{{ $currentModule->getDatatableUrl() }}">
                                        <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th><i class="fa fa-tag"></i> Número</th>
                                            <th><i class="fa fa-user"></i> Cliente</th>
                                            <th><i class="fa fa-money"></i> Valor</th>
                                            <th><i class="fa fa-calendar"></i> Criado em</th>
                                            <th><i class="fa fa-edit"></i> Status</th>
                                            <th><i class="fa fa-edit"></i> Status da integração</th>
                                            <th>Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td width="5%">{{ $order->id }}</td>
                                                    <td width="8%">{{ $order->number }}</td>
                                                    <td width="15%">{{ $order->customer->name }}</td>
                                                    <td width="10%">{{ $order->total }}</td>
                                                    <td width="10%">{{ $order->created_at }}</td>
                                                    <td width="19%">{{ $order->status }}</td>
                                                    <td width="10%">{!! $order->integration_status_html !!}</td>
                                                    <td width="8%">
                                                        <a href="{{ route('cms.orders.show', $order->id) }}" target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fa fa-eye"></i> Visualizar
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    {!! $orders->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    @parent
    <script src="{{ asset_cms('pages/orders/ordersListPage.js') }}"></script>
@endsection
@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-eye"></i> Visualizando cliente #{{ $customer->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">
            <div class="col-md-3">

                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{ $customer->profile_photo }}" alt="User profile picture">

                        <h3 class="profile-username text-center">{{ $customer->name }}</h3>

                        <p class="text-muted text-center">Cliente desde {{ $customer->member_since_date }}</p>

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Total de pedidos</b> <a class="pull-right"> {{ $customer->stats()->orders() }}</a>
                            </li>
                        </ul>

                        @if ($loggedUser->hasPermissionTo('cms.customers.edit'))
                            <a href="{{ route('cms.customers.edit', $customer->getId()) }}" class="btn btn-primary btn-block"><b><span class="fa fa-edit"></span> Editar dados</b></a>
                        @endif
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Informações</h3>
                    </div>
                    <div class="box-body">
                        <strong><i class="fa fa-book margin-r-5"></i> Sobre</strong>
                        <p class="text-muted">
                            <b>Tipo de pessoa: </b> {{ $customer->customer_type }}<br />
                            <b>Data de nascimento: </b> {{ $customer->birthday }}<br />
                            <b>Sexo: </b> {{ $customer->gender }}<br />
                        </p>
                        <hr>

                        <strong><i class="fa fa-edit margin-r-5"></i> Contato</strong><br /><br />
                        <p class="text-muted">
                            <b>E-mail: </b> {{ $customer->email }}<br />
                            @if($customer->hasCellPhone())
                            <b>Celular: </b> {{ $customer->cell_phone }}<br />
                            @endif
                            <b>Telefone: </b> {{ $customer->phone }}<br />
                            @if($customer->hasCommercialPhone())
                            <b>Telefone comercial: </b> {{ $customer->commercial_phone }}<br />
                            @endif
                        </p>
                        <hr>

                        <strong><i class="fa fa-map-marker margin-r-5"></i> Endereço</strong>
                        <p class="text-muted">
                            {!! $customer->full_address_html !!}
                        </p>
                        <hr>
                    </div>
                </div>

            </div>

            <div class="col-md-9">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#addresses" data-toggle="tab">Endereços cadastrados</a></li>
                        <li><a href="#orders" data-toggle="tab">Pedidos realizados</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane" id="addresses">

                        </div>
                        <div class="tab-pane" id="orders">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
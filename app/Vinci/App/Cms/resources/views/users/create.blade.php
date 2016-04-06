@extends('cms::layouts.master')

@section('content')

    <section class="content-header">
        <h1>Usuários</h1>
        <ol class="breadcrumb">
            <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ route('cms.users.list') }}"><i class="fa fa-user"></i> Usuários</a></li>
            <li class="active"><i class="fa fa-plus"></i> Novo usuário</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">

            {!! Form::open(['route' => 'cms.users.store', 'method' => 'post']) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Novo usuário</h3>
                </div>

                    <div class="box-body">
                        @include('cms::users.form')

                        <div class="form-group">
                            <label for="exampleInputEmail1">Grupo</label>
                            {!! Form::select('roles', ['' => 'Selecione o grupo'] + $roles, null, ['id' => 'selectUserRole', 'class' => 'form-control select2']) !!}
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                @include('cms::layouts.partials.publication.create.default')
            </div>

            {!! Form::close() !!}

        </div>
    </section>

@endsection
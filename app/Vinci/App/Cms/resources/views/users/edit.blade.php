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

            {!! Form::model($user, ['route' => ['cms.users.update', $user->getId()], 'method' => 'PUT']) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar usuário</h3>
                    </div>

                    {!! Form::hidden('id', $user->getId()) !!}

                    <div class="box-body">

                        @include('cms::users.form')

                        <div class="form-group">
                            <label for="exampleInputEmail1">Grupo</label>
                            <select name="roles" id="selectUserRoles" class="form-control select2">
                                <option value="">Selecione o grupo</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->getId() }}" @if(old('roles') == $role->getId() || $user->hasRole($role)) selected @endif>{{ $role->getTitle() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                @include('cms::layouts.partials.publication.edit.default', ['model' => $user])
            </div>

        </div>

        {!! Form::close() !!}

        </div>
    </section>

@endsection
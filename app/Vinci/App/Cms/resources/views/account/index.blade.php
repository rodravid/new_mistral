@extends('cms::layouts.master')

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-3">

                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive img-circle" src="{{ $loggedUser->profile_photo }}" alt="User profile picture">

                        <h3 class="profile-username text-center">
                            {{ $loggedUser->name }} <br>
                            <small>
                                {!! $loggedUser->office !!}<br>
                                Grupo: {{ $loggedUser->getRoles()->first()->title }}<br>
                                <b>E-mail: </b> {{ $loggedUser->email }}
                            </small>
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-9">

                <div class="box box-primary">
                    <div class="box-body box-profile">

                        <div class="row">
                            <div class="col-md-4">
                                {!! Form::model($loggedUser, ['route' => ['cms.profile.update', $loggedUser->getId()], 'method' => 'PUT', 'files' => true]) !!}
                                {!! Form::hidden('id') !!}
                                {!! Form::hidden('roles', $loggedUser->getRoles()->first()->getId()) !!}
                                <div class="col-xs-12">
                                    <h4>
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        Dados Pessoais
                                    </h4>

                                    <div class="form-group has-feedback">
                                        <label for="txtUserName">Nome</label>
                                        {!! Form::text('name', null, ['id' => 'txtUserName', 'class' => 'form-control', 'placeholder' => 'Digite o nome']) !!}
                                        <span class="fa fa-pencil form-control-feedback"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="txtUserEmail">E-mail</label>
                                        {!! Form::text('email', null, ['id' => 'txtUserEmail', 'class' => 'form-control', 'placeholder' => 'Digite o e-mail']) !!}
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="txtUserEmail">Cargo</label>
                                        {!! Form::text('office', null, ['id' => 'txtUserOffice', 'class' => 'form-control', 'placeholder' => 'Digite o cargo']) !!}
                                        <span class="fa fa-pencil form-control-feedback"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="txtUserPassword">Nova senha</label>
                                        {!! Form::password('password', ['id' => 'txtUserPassword', 'class' => 'form-control', 'placeholder' => 'Digite a senha']) !!}
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="txtUserPasswordConfirmation">Confirmação da nova senha</label>
                                        {!! Form::password('password_confirmation', ['id' => 'txtUserPasswordConfirmation', 'class' => 'form-control', 'placeholder' => 'Digite a senha novamente']) !!}
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="txtUserPasswordConfirmation">Foto</label>
                                        {!! Form::file('photo', ['id' => 'txtUserPhoto']) !!}
                                        <span class="glyphicon glyphicon-picture form-control-feedback"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <button type="submit" class="btn btn-success col-md-12">Salvar</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>

                            <div class="col-md-8">
                                <h4>Temas</h4>
                                <ul class="list-unstyled clearfix">
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                                                <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin">Blue</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                <span style="display:block; width: 20%; float: left; height: 7px; background: #333;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 7px; background: #333;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin">Black</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                                <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin">Purple</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                                <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin">Green</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                                <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin">Red</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                                <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin">Yellow</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span>
                                                <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
                                                <span style="display:block; width: 20%; float: left; height: 7px; background: #333;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 7px; background: #333;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
                                                <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
                                                <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
                                                <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
                                    </li>
                                    <li style="float:left; width: 50%; padding: 5px;">
                                        <a href="javascript:void(0);" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
                                                <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
                                            </div>
                                            <div>
                                                <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc;"></span>
                                                <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7;"></span>
                                            </div>
                                        </a>
                                        <p class="text-center no-margin" style="font-size: 12px;">Yellow Light</p>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                @if (! $loggedUser->isSuperAdmin())
                    <div class="box box-info collapsed-box">
                        <div class="box-header">

                            <h3 class="box-title">
                                <i class="fa fa-check-square-o"></i>
                                Permissões
                            </h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body border-radius-none">
                            @foreach ($loggedUser->getPermissionsGroupedByModules() as $aggregate)
                                <div class="col-md-4">
                                    <div class="panel panel-default" style="height: 158px;">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">{{ $aggregate['module']->getTitle() }}</h3>
                                        </div>
                                        <div class="panel-body">
                                            <ul>
                                                @foreach ($aggregate['permissions'] as $permission)
                                                    <li>{{ $permission->getDescription() }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>
@endsection
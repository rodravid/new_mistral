@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> Editando usuário #{{ $user->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($user, ['route' => ['cms.users.edit#update', $user->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar usuário #{{ $user->getId() }}</h3>
                    </div>

                    {!! Form::hidden('id', $user->getId()) !!}

                    <div class="box-body">

                        @include('cms::users.form')

                        <div class="form-group">
                            <label for="selectUserRoles">Grupo</label>
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

            @if ($user->hasProfilePhoto())
                <div class="col-xs-12 col-lg-3">
                    @include('cms::layouts.partials.image.default', [
                    'box_title' => 'Foto do perfil',
                    'image' => $user->getProfilePhoto(),
                    'delete_url' => route('cms.users.edit#remove-photo', [$user->getId(), $user->getProfilePhoto()->getId()])
                    ])
                </div>
            @endif

            {!! Form::close() !!}

        </div>
    </section>

@endsection
@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="fa fa-user"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> Editando grupo #{{ $role->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($role, ['route' => ['cms.roles.edit#update', $role->getId()], 'method' => 'PUT', 'files' => true]) !!}

                <div class="col-xs-12 col-lg-9">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Editar grupo #{{ $role->getId() }}</h3>
                        </div>

                        {!! Form::hidden('id', $role->getId()) !!}

                        <div class="box-body">
                            @include('cms::roles.form')
                            <div class="row">
                                <div class="col-xs-12">
                                    <label for="txtUserEmail">Permissões</label>

                                    <div class="row">
                                        @foreach($groupedPermissions as $permissionGroup)
                                            <div class="col-xs-6 col-sm-4 col-md-3">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="modules[]" value="{{ $permissionGroup['module']->getId() }}" @if($role->getModules()->contains($permissionGroup['module'])) checked @endif data-checkall><b>{{ $permissionGroup['module']->getTitle() }}</b></label>
                                                </div>
                                                <div class="form-group">
                                                    @foreach($permissionGroup['permissions'] as $permission)
                                                        @if($permission->canBeListed())
                                                            <div class="checkbox">
                                                                <label><input type="checkbox" name="permissions[]" value="{{ $permission->getId() }}" @if($role->getPermissions()->contains($permission)) checked @endif>{{ $permission->getDescription() }}</label>
                                                            </div>
                                                        @else
                                                            <input type="hidden" name="permissions[]" value="{{ $permission->getId() }}">
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xs-12 col-lg-3">
                    @include('cms::layouts.partials.publication.edit.default', ['model' => $role])
                </div>

            {!! Form::close() !!}

        </div>
    </section>

@endsection
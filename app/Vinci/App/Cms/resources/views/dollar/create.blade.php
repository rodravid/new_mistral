@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-plus"></i> Nova cotação do dólar</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::open(['route' => 'cms.dollar.create#store', 'method' => 'post', 'files' => true]) !!}

                <div class="col-xs-12 col-lg-9">
                    <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Nova cotação</h3>
                    </div>

                        <div class="box-body">
                            @include('cms::dollar.form')
                        </div>

                    </div>
                </div>

                <div class="col-xs-12 col-lg-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Publicação</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <span id="startText">Publicar <strong>imediatamente</strong></span>
                                <a class="publishing-action blue">Editar</a>
                                <div class="publishing-fields" style="display: none;">
                                    <div class="input-group date" id="txtStartsAtPicker">
                                        {{ Form::text('startsAt', \Carbon\Carbon::now()->format('d/m/Y H:i'), ['id' => 'txtStartsAt', 'class' => 'form-control']) }}
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success btn-block" name="status" value="1"><i class="fa fa-check"></i> Salvar e publicar</button>
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

        </div>
    </section>

@endsection
@extends('cms::roles.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-plus"></i> Novo grupo</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::open(['route' => 'cms.roles.create#store', 'method' => 'post', 'files' => true]) !!}

                <div class="col-xs-12 col-lg-9">
                    <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Novo grupo</h3>
                    </div>

                        <div class="box-body">
                            @include('cms::roles.form')
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
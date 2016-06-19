@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i
                        class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-plus"></i> {{ $currentModule->getCreateButtonText() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::open(['route' => 'cms.' . $currentModule->getName() . '.create#store', 'method' => 'post', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $currentModule->getCreateButtonText() }}</h3>
                    </div>

                    <div class="box-body">
                        @include('cms::promotions.discount.form')
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                @include('cms::layouts.partials.publication.create.default', ['hasDraft' => true, 'hasSchedule' => true])
            </div>

            {!! Form::close() !!}

        </div>
    </section>

@endsection
@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $producer->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($producer, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $producer->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $producer->getId() }}</h3>
                            </div>

                            {!! Form::hidden('id', $producer->getId()) !!}

                            <div class="box-body">
                                @include('cms::countries.form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                <div class="row">
                    <div class="col-xs-12">
                        @include('cms::layouts.partials.publication.edit.default', ['model' => $producer])
                    </div>

                    @if ($producer->hasImage('map'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Mapa',
                            'image' => $producer->getImage('map'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$producer->getId(), $producer->getImage('map')->getId()])
                            ])
                        </div>
                    @endif

                    @if ($producer->hasImage('banner'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Banner',
                            'image' => $producer->getImage('banner'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$producer->getId(), $producer->getImage('banner')->getId()])
                            ])
                        </div>
                    @endif

                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>

@endsection
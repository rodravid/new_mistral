@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $region->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($region, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $region->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $region->getId() }}</h3>
                            </div>

                            {!! Form::hidden('id', $region->getId()) !!}

                            <div class="box-body">
                                @include('cms::regions.form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                <div class="row">
                    <div class="col-xs-12">
                        @include('cms::layouts.partials.publication.edit.default', ['model' => $region])
                    </div>

                    @if ($region->hasImage('map'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Mapa',
                            'image' => $region->getImage('map'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$region->getId(), $region->getImage('map')->getId()])
                            ])
                        </div>
                    @endif

                    @if ($region->hasImage('banner'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Banner',
                            'image' => $region->getImage('banner'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$region->getId(), $region->getImage('banner')->getId()])
                            ])
                        </div>
                    @endif

                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>

@endsection
@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $country->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($country, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $country->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $country->getId() }}</h3>
                            </div>

                            {!! Form::hidden('id', $country->getId()) !!}

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
                        @include('cms::layouts.partials.publication.edit.default', ['model' => $country])
                    </div>

                    @if ($country->hasImage('map'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Mapa',
                            'image' => $country->getImage('map'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$country->getId(), $country->getImage('map')->getId()])
                            ])
                        </div>
                    @endif

                    @if ($country->hasImage('banner'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Banner',
                            'image' => $country->getImage('banner'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$country->getId(), $country->getImage('banner')->getId()])
                            ])
                        </div>
                    @endif

                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>

@endsection
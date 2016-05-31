@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $highlight->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($highlight, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $highlight->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $highlight->getId() }}</h3>
                            </div>

                            {!! Form::hidden('id', $highlight->getId()) !!}

                            <div class="box-body">
                                @if($currentModule->getName() == "home-banners")
                                    @include('cms::highlights.form_banners')
                                @else
                                    @include('cms::highlights.form')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                <div class="row">
                    <div class="col-xs-12">
                        @include('cms::layouts.partials.publication.edit.default', ['model' => $highlight])
                    </div>

                    @if ($highlight->hasImage('mobile'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Imagem',
                            'image' => $highlight->getImage('mobile'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$highlight->getId(), $highlight->getImage('mobile')->getId()])
                            ])
                        </div>
                    @endif

                    @if ($highlight->hasImage('desktop'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Imagem',
                            'image' => $highlight->getImage('desktop'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$highlight->getId(), $highlight->getImage('desktop')->getId()])
                            ])
                        </div>
                    @endif

                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>

@endsection
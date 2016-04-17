@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $grape->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($grape, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $grape->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $grape->getId() }}</h3>
                            </div>

                            {!! Form::hidden('id', $grape->getId()) !!}

                            <div class="box-body">
                                @include('cms::grapes.form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                <div class="row">
                    <div class="col-xs-12">
                        @include('cms::layouts.partials.publication.edit.default', ['model' => $grape])
                    </div>

                    @if ($grape->hasImage('picture'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Imagem',
                            'image' => $grape->getImage('picture'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$grape->getId(), $grape->getImage('picture')->getId()])
                            ])
                        </div>
                    @endif

                    @if ($grape->hasImage('picture_mobile'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Imagem mobile',
                            'image' => $grape->getImage('picture_mobile'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$grape->getId(), $grape->getImage('picture_mobile')->getId()])
                            ])
                        </div>
                    @endif

                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>

@endsection
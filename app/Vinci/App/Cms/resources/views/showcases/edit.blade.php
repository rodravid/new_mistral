@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $showcase->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($showcase, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $showcase->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $showcase->getId() }}</h3>
                                <a href="{{ $showcase->getWebPath() }}" target="__blank" class="btn btn-info pull-right"><i class="fa fa-eye"></i> Ver vitrine no site</a>
                            </div>

                            {!! Form::hidden('id', $showcase->getId()) !!}

                            <div class="box-body">
                                @include('cms::showcases.form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                <div class="row">
                    <div class="col-xs-12">
                        @include('cms::layouts.partials.publication.edit.default', ['model' => $showcase])
                    </div>

                    @if ($showcase->hasImage('banner'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Banner',
                            'image' => $showcase->getImage('banner'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$showcase->getId(), $showcase->getImage('banner')->getId()])
                            ])
                        </div>
                    @endif

                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>

@endsection
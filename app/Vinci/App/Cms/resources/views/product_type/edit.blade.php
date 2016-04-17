@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $productType->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($productType, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $productType->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $productType->getId() }}</h3>
                            </div>

                            {!! Form::hidden('id', $productType->getId()) !!}

                            <div class="box-body">
                                @include('cms::product_type.form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                <div class="row">
                    <div class="col-xs-12">
                        @include('cms::layouts.partials.publication.edit.default', ['model' => $productType])
                    </div>

                    @if ($productType->hasImage('picture'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Imagem',
                            'image' => $productType->getImage('picture'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$productType->getId(), $productType->getImage('picture')->getId()])
                            ])
                        </div>
                    @endif

                    @if ($productType->hasImage('picture_mobile'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Imagem mobile',
                            'image' => $productType->getImage('picture_mobile'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$productType->getId(), $productType->getImage('picture_mobile')->getId()])
                            ])
                        </div>
                    @endif

                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>

@endsection
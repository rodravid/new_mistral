@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $product->getId() }} - {{ $product->getTitle() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($product, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $product->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $product->getId() }} - {{ $product->getTitle() }}</h3>
                        <a href="{{ $product->getWebPath() }}" target="__blank" class="btn btn-info pull-right"><i class="fa fa-eye"></i> Ver produto no site</a>
                        <div class="checkbox pull-right" style="margin-right: 20px;">
                            <label><input type="checkbox" class="" name="online" value="1" @if($product->isOnline()) checked @endif>Visível no site?</label>
                        </div>
                    </div>

                    {!! Form::hidden('id', $product->getId()) !!}

                    <div class="box-body">
                        @include('cms::products.form')
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                <div class="row">
                    <div class="col-xs-12">
                        @include('cms::layouts.partials.publication.edit.default', ['model' => $product])
                    </div>

                    @if ($product->hasImage('photo'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Foto',
                            'image' => $product->getImage('photo'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$product->getId(), $product->getImage('photo')->getId()])
                            ])
                        </div>
                    @endif

                    @if ($product->hasImage('desktop'))
                        <div class="col-xs-12">
                            @include('cms::layouts.partials.image.default', [
                            'box_title' => 'Imagem desktop',
                            'image' => $product->getImage('desktop'),
                            'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$product->getId(), $product->getImage('desktop')->getId()])
                            ])
                        </div>
                    @endif
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>

@endsection
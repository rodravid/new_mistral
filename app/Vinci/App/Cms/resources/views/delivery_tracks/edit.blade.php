@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $deliveryTrack->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($deliveryTrack, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $deliveryTrack->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $deliveryTrack->getId() }}</h3>
                            </div>

                            {!! Form::hidden('id', $deliveryTrack->getId()) !!}

                            <div class="box-body">
                                @include('cms::delivery_tracks.form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                <div class="row">
                    <div class="col-xs-12">
                        @include('cms::layouts.partials.publication.edit.default', ['model' => $deliveryTrack])
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>

@endsection
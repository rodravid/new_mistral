@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> {{ $currentModule->getEditingText() }} #{{ $customer->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($customer, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $customer->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ $currentModule->getEditingText() }} #{{ $customer->getId() }}</h3>
                    </div>

                    {!! Form::hidden('id', $customer->getId()) !!}

                    <div class="box-body">
                        @include('cms::customers.form')
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                @include('cms::layouts.partials.publication.edit.default', ['model' => $customer, 'hideDraft' => true])
            </div>

            {!! Form::close() !!}

            @include('cms::customers.partials.address.modal.new')
        </div>
    </section>

@endsection
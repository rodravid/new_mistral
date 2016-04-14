@extends('cms::layouts.module')

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="/cms"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ $currentModule->getUrl() }}"><i class="{{ $currentModule->getIcon() }}"></i> {{ $currentModule->getTitle() }}</a></li>
        <li class="active"><i class="fa fa-edit"></i> Editando destaque #{{ $highlight->getId() }}</li>
    </ol>
@endsection

@section('module.content')

    <section class="content">
        <div class="row">

            {!! Form::model($highlight, ['route' => ['cms.' . $currentModule->getName() . '.edit#update', $highlight->getId()], 'method' => 'PUT', 'files' => true]) !!}

            <div class="col-xs-12 col-lg-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Editar destaque #{{ $highlight->getId() }}</h3>
                    </div>

                    {!! Form::hidden('id', $highlight->getId()) !!}

                    <div class="box-body">
                        @include('cms::highlights.form')
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-lg-3">
                @include('cms::layouts.partials.publication.edit.default', ['model' => $highlight])
            </div>

            @if ($highlight->hasImage('desktop'))
                <div class="col-xs-12 col-lg-3">
                    @include('cms::layouts.partials.image.default', [
                    'box_title' => 'Imagem desktop',
                    'image' => $highlight->getImage('desktop'),
                    'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$highlight->getId(), $highlight->getImage('desktop')->getId()])
                    ])
                </div>
            @endif

            @if ($highlight->hasImage('mobile'))
                <div class="col-xs-12 col-lg-3">
                    @include('cms::layouts.partials.image.default', [
                    'box_title' => 'Imagem mobile',
                    'image' => $highlight->getImage('mobile'),
                    'delete_url' => route('cms.' . $currentModule->getName() . '.edit#remove-image', [$highlight->getId(), $highlight->getImage('mobile')->getId()])
                    ])
                </div>
            @endif

            {!! Form::close() !!}

        </div>
    </section>

@endsection

@section('scripts')
    @parent

    <script type="text/javascript">

        $("#clearDate").click(function(event) {
            $('#endText').html('<strong>Nunca expira!</strong>');
            $(this).siblings('input').val('');
            $(this).parents('.publishing-fields').first().slideUp(500);
        });

        $(function(){
            $('#txtStartsAtPicker').datetimepicker({
                locale: 'pt-br'
            }).bind('dp.change', function() {
                var publishingDate = $('#txtStartsAtPicker').data("DateTimePicker").getDate();
                var currentDate = new Date();
                var startDate = moment(publishingDate);

                if(publishingDate <= currentDate) {
                    $('#startText').html('Publicar <strong>imediatamente</strong>');
                } else {
                    $('#startText').html('Publicar em <strong>' + startDate.format('DD/MM/YYYY HH:mm') + '</strong>');
                };
            });

            $('#txtExpirationAtPicker').datetimepicker().bind('dp.change', function() {
                var finishingDate = $('#txtExpirationAtPicker').data("DateTimePicker").getDate();
                var endDate = moment(finishingDate);
                $('#endText').html('Publicado até <strong>' + endDate.format('DD/MM/YYYY HH:mm') + '</strong>');
            });

            $('#txtStartsAtPicker').data("DateTimePicker").setMinDate(moment().startOf('day'));
            $('#txtExpirationAtPicker').data("DateTimePicker").setMinDate(moment().startOf('day'));
        });

        $('.publishing-action').click(function() {
            var fields = $(this).siblings('.publishing-fields');
            if(fields.is(':hidden'))
                fields.stop().slideDown(500);
            else
                fields.stop().slideUp(500);
        });

    </script>

@endsection
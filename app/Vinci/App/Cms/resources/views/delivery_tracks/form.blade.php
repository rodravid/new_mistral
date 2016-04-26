<div class="row">

    <div class="col-xs-12">
        <div class="form-group has-feedback">
            <label for="txtTrackTitle">Título</label>
            {!! Form::text('title', null, ['id' => 'txtTrackTitle', 'class' => 'form-control', 'placeholder' => 'Digite um título para a faixa de CEP']) !!}
            <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
        </div>
    </div>

    <div class="col-xs-12">
        <label for="txtTrackTitle">Faixas de CEP</label><br />
        <button type="button" class="btn btn-xs btn-success" id="btnAddTrack"><i class="fa fa-plus-circle"></i> Adicionar</button>

        <div class="row" style="margin-top: 20px;">
            <div class="col-xs-12" id="boxTracks">

                @if($lines)
                    @foreach($lines as $i => $line)
                        <div class="row item">
                            <div class="col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row relative">
                                            <div class="col-lg-3">
                                                <input type="text" name="line[{{ $i }}][initial_track]" class="form-control" placeholder="CEP inicial" data-mask data-inputmask="'mask': '99999-999'" value="{{ $line->getInitialTrack() }}">
                                            </div>
                                            <div class="col-lg-3">
                                                <input type="text" name="line[{{ $i }}][final_track]" class="form-control" placeholder="CEP final" data-mask data-inputmask="'mask': '99999-999'" value="{{ $line->getFinalTrack() }}">
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" name="line[{{ $i }}][description]" class="form-control" placeholder="Descrição (opcional)" value="{{ $line->getDescription() }}">
                                            </div>
                                            @if($i > 0)
                                                <button type="button" class="btn btn-xs btn-danger btnRemoveTrack" style="position: absolute; right: 3px; top: 50%; margin-top: -20px;" title="Remover"><i class="fa fa-minus-circle"></i></button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="row item">
                        <div class="col-xs-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row relative">
                                        <div class="col-lg-3">
                                            <input type="text" name="line[0][initial_track]" class="form-control" placeholder="CEP inicial" data-mask data-inputmask="'mask': '99999-999'">
                                        </div>
                                        <div class="col-lg-3">
                                            <input type="text" name="line[0][final_track]" class="form-control" placeholder="CEP final" data-mask data-inputmask="'mask': '99999-999'">
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" name="line[0][description]" class="form-control" placeholder="Descrição (opcional)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

@section('scripts')
    @parent

    <script type="text/javascript">

        (function($) {

            var index = 1;
            var $boxTracks = $('#boxTracks');

            $('#btnAddTrack').bind('click', function(e) {

                var $itemHtml = $('<div class="row item">' +
                    '<div class="col-xs-12">' +
                    '<div class="panel panel-default">' +
                    '<div class="panel-body">' +
                    '<div class="row relative">' +
                    '<div class="col-lg-3">' +
                    '<input type="text" name="line[i' + index + '][initial_track]" class="form-control" placeholder="CEP inicial" data-mask data-inputmask="\'mask\': \'99999-999\'">' +
                    '</div>' +
                    '<div class="col-lg-3">' +
                    '<input type="text" name="line[i' + index + '][final_track]" class="form-control" placeholder="CEP final" data-mask data-inputmask="\'mask\': \'99999-999\'">' +
                    '</div>' +
                    '<div class="col-lg-6">' +
                    '<input type="text" name="line[i' + index + '][description]" class="form-control" placeholder="Descrição (opcional)">' +
                    '</div>' +
                    '<button type="button" class="btn btn-xs btn-danger btnRemoveTrack" style="position: absolute; right: 3px; top: 50%; margin-top: -20px;" title="Remover"><i class="fa fa-minus-circle"></i></button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>');

                $itemHtml.appendTo($boxTracks);

                $itemHtml.find('[data-mask]').inputmask();

                index++;

                e.preventDefault();
            });

            $('body').delegate('.btnRemoveTrack', 'click', function(e) {

                var $self = $(this);

                $self.parents('.item').slideUp(300, function() {
                    $(this).remove();
                });

                e.preventDefault();
            });

        })($);

    </script>

@endsection
<div class="tab-pane {{ currentTabActive('#productScores') }}" id="productScores">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <button type="button" id="btnAddScore" class="btn btn-success" title="Adicionar uva"><i class="fa fa-plus-circle"></i> Adicionar</button>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" id="boxScores">
                    @if($wineScores)
                        @foreach($wineScores as $key => $score)
                            <div class="row item" style="position: relative; margin-top: 20px;">
                                <div class="col-xs-12 col-sm-4">
                                    <div class="form-group">
                                        <label>Crítico</label>
                                        {!! Form::select('scores[' . $key . '][critical_acclaim_id]', $wineCriticalAcclaims, is_object($score) ? [$score->getCriticalAcclaim()->getId()] : $score['critical_acclaim_id'], ['class' => 'form-control selectCriticalAcclaim']) !!}
                                        {!! Form::hidden('scores[' . $key . '][id]', $score['id']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="form-group">
                                        <label>Ano</label>
                                        {!! Form::text('scores[' . $key . '][year]', $score['year'], ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="form-group">
                                        <label>Pontos</label>
                                        {!! Form::text('scores[' . $key . '][value]', $score['value'], ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-2">
                                    <div class="form-group">
                                        <div class="checkbox" style="margin-top: 30px;">
                                            <input type="hidden" name="scores[{{ $key }}][highlighted]" value="0">
                                            <label for="ckbScoreHighlight">
                                                <input id="highlited{{ $key }}" type="checkbox" name="scores[{{ $key }}][highlighted]" value="1" @if(old('scores.0.highlighted', is_object($score) ? $score->isHighlighted() : $score['highlighted'])) checked @endif>
                                                <label for="highlited{{ $key }}">Destaque?</label>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label>Descrição</label>
                                        {!! Form::text('scores[' . $key . '][description]', $score['description'], ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger btnRemoveScore" style="position: absolute; bottom: 80px; right: 15px;" title="Remover pontuação"><i class="fa fa-minus-circle"></i> Remover</button>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent

    <script type="text/javascript">

        (function($) {

            var index = 1;
            var $boxScores = $('#boxScores');

            $('#btnAddScore').bind('click', function(e) {

                var $itemHtml = $('<div class="row item" style="position: relative; margin-top: 20px;">' +
                '<div class="col-xs-12 col-sm-4">' +
                '<div class="form-group">' +
                '<label>Crítico</label>' +
                '<select class="form-control selectCriticalAcclaim" name="scores[i' + index + '][critical_acclaim_id]">@foreach($wineCriticalAcclaims as $key => $criticalAcclaim) <option value="{{ $key }}">{{ $criticalAcclaim }}</option> @endforeach</select>' +
                '<input type="hidden" name="scores[i' + index + '][id]" value="">' +
                '</div>' +
                '</div>' +
                '<div class="col-xs-12 col-sm-2">' +
                '<div class="form-group">' +
                '<label>Ano</label>' +
                '<input type="text" name="scores[i' + index + '][year]" class="form-control" value="">' +
                '</div>' +
                '</div>' +
                '<div class="col-xs-12 col-sm-2">' +
                '<div class="form-group">' +
                '<label>Pontos</label>' +
                '<input type="text" name="scores[i' + index + '][value]" class="form-control" value="">' +
                '</div>' +
                '</div>' +
                '<div class="col-xs-12 col-sm-2">' +
                '<div class="form-group">' +
                '<input type="hidden" name="scores[i' + index + '][highlighted]" value="0">' +
                '<div class="checkbox" style="margin-top: 30px;">' +
                '<label for="highlitedi' + index + '"><input type="checkbox" name="scores[i' + index + '][highlighted]" value="1" id="highlitedi' + index + '"> Destaque?</label>' +
                '</div>' +
                '</div>' +
                '</div>' +
                    '<div class="col-xs-12">' +
                        '<div class="form-group">' +
                            '<label>Descrição</label>' +
                            '<input type="text" name="scores[i' + index + '][description]" class="form-control" value="">' +
                        '</div>' +
                    '</div>' +
                    '<button type="button" class="btn btn-danger btnRemoveScore" style="position: absolute; bottom: 80px; right: 15px;" title="Remover uva"><i class="fa fa-minus-circle"></i> Remover</button>' +
                '</div>');

                $itemHtml.appendTo($boxScores);

                index++;

                e.preventDefault();
            });

            $('body').delegate('.btnRemoveScore', 'click', function(e) {

                var $self = $(this);

                $self.parents('.item').slideUp(300, function() {
                    $(this).remove();
                });

                e.preventDefault();
            });

        })($);

    </script>

@endsection
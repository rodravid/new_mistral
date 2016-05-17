<div class="tab-pane {{ currentTabActive('#productGrapes') }}" id="productGrapes">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-6 col-sm-6">
                    <div class="form-group">
                        <label>Selecione o tipo de uva</label>
                        {!! Form::select(null, ['' => 'Selecione a uva'] + $grapes, null, ['id' => 'selectGrape', 'class' => 'form-control select2', 'style' => 'width: 100%']) !!}
                    </div>
                </div>
                <div class="col-xs-3 col-sm-4">
                    <div class="form-group">
                        <label>Peso %</label>
                        {!! Form::text(null, null, ['id' => 'txtGrapeWeight', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-2 col-sm-2">
                    <button type="button" id="btnAddGrape" class="btn btn-success" style="margin-top: 24px;" title="Adicionar uva"><i class="fa fa-plus-circle"></i> <span class="hidden-xs">Adicionar</span></button>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12" id="boxGrapes">
                    @if($wineGrapes)
                        @foreach($wineGrapes as $i => $grape)
                            <div class="row item">
                                <div class="col-xs-6 col-sm-6">
                                    <div class="form-group">
                                        <label>Uva</label>
                                        {!! Form::text('grapes[' . $i . '][name]', $grape['name'], ['class' => 'form-control', 'readonly']) !!}
                                        {!! Form::hidden('grapes[' . $i . '][id]', $grape['id'], ['class' => 'txtGrapeId']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-4">
                                    <div class="form-group">
                                        <label>Peso %</label>
                                        {!! Form::text('grapes[' . $i . '][weight]', $grape['weight'], ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-2 col-sm-2">
                                    <button type="button" class="btn btn-danger btnRemoveGrape" style="margin-top: 24px;" title="Remover uva"><i class="fa fa-minus-circle"></i> <span class="hidden-xs">Remover</span></button>
                                </div>
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
            var $boxGrapes = $('#boxGrapes');
            var $selectGrape = $('#selectGrape');
            var $txtGrapeWeight = $('#txtGrapeWeight');

            $('#btnAddGrape').bind('click', function(e) {

                var grape = {
                    id: $selectGrape.val(),
                    name: $selectGrape.find('option:selected').text(),
                    weight: parseFloat($txtGrapeWeight.val())
                };

                var alreadyAdded = $boxGrapes.find('.txtGrapeId[value="' + grape.id + '"]').length > 0;

                if (alreadyAdded) {
                    return false;
                }

                if (grape.id > 0 && grape.weight > 0) {

                    var $itemHtml = $('<div class="row item">' +
                            '<div class="col-xs-6 col-sm-6">' +
                            '<div class="form-group">' +
                            '<label>Uva</label>' +
                            '<input type="text" name="grapes[i' + index + '][name]" class="form-control" value="' + grape.name + '" readonly>' +
                            '<input type="hidden" name="grapes[i' + index + '][id]" class="txtGrapeId" value="' + grape.id + '">' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-xs-3 col-sm-4">' +
                            '<div class="form-group">' +
                            '<label>Peso %</label>' +
                            '<input type="text" name="grapes[i' + index + '][weight]" class="form-control" value="' + grape.weight + '">' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-xs-2 col-sm-2">' +
                            '<button type="button" class="btn btn-danger btnRemoveGrape" style="margin-top: 24px;" title="Remover uva"><i class="fa fa-minus-circle"></i> <span class="hidden-xs">Remover</span></button>' +
                            '</div>' +
                            '</div>');

                    $itemHtml.appendTo($boxGrapes);

                    $itemHtml.find('[data-mask]').inputmask();

                    $txtGrapeWeight.val('');
                    $selectGrape.find('option:first').prop('selected', true).trigger('change');

                    index++;
                } else {

                    swal('Erro!', 'Você deve selecionar um tipo de uva e informar o peso em porcentagem (%).', 'error');

                }

                e.preventDefault();
            });

            $('body').delegate('.btnRemoveGrape', 'click', function(e) {

                var $self = $(this);

                $self.parents('.item').slideUp(300, function() {
                    $(this).remove();
                });

                e.preventDefault();
            });

        })($);

    </script>

@endsection
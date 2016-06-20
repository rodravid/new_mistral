<div class="tab-pane {{ currentTabActive('#tabData', 'active', true) }}" id="tabData">
    <input type="hidden" name="channel" value="1">
    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="form-group has-feedback">
                <label for="txtShowcaseTitle">Título</label>
                {!! Form::text('title', null, ['id' => 'txtShowcaseTitle', 'class' => 'form-control', 'placeholder' => 'Digite o título']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="form-group has-feedback">
                <label for="txtShowcaseDescription">Descrição</label>
                {!! Form::textarea('description', null, ['id' => 'txtShowcaseDescription', 'class' => 'form-control html-editor-especial', 'placeholder' => 'Digite a descrição', 'rows' => '3']) !!}
                <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="form-group">
                <label for="txtShowcaseTitle">Tipo de desconto</label>
                {!! Form::select('discountType', [
                \Vinci\Domain\Pricing\Contracts\DiscountType::FIXED => 'Fixo',
                \Vinci\Domain\Pricing\Contracts\DiscountType::PERCENTAGE => 'Porcentagem',
                \Vinci\Domain\Pricing\Contracts\DiscountType::EXCHANGE_RATE => 'Taxa de câmbio'
                ], null, ['id' => 'txtDiscountType', 'class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="form-group has-feedback">
                        <label for="txtShowcaseTitle">Valor do desconto</label>
                        {!! Form::text('discountAmount', null, ['id' => 'txtDiscountAmount', 'class' => 'form-control', 'placeholder' => 'Valor do desconto']) !!}
                        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
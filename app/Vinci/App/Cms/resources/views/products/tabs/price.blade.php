<div class="tab-pane {{ currentTabActive('#productPrices') }}" id="productPrices">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group">
                        <label>Canal de venda</label>
                        {!! Form::select('price[0][channel]', ['default' => 'Padrão'], null, ['class' => 'form-control', 'disabled', 'readonly']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group has-feedback">
                        <label>Preço em dólar</label>
                        {!! Form::text('price[0][price]', null, ['class' => 'form-control']) !!}
                        <span class="fa fa-dollar form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group has-feedback">
                        <label>Valor do dólar</label>
                        {!! Form::text('price[0][currency_amount]', null, ['class' => 'form-control']) !!}
                        <span class="fa fa-money form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group has-feedback">
                        <label>IPI %</label>
                        {!! Form::text('price[0][aliquot_ipi]', null, ['class' => 'form-control']) !!}
                        <span class="fa fa-percent form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group">
                        <label>Tipo de desconto</label>
                        {!! Form::select('price[0][discount_type]', $discountTypes, null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group has-feedback">
                        <label>Valor do desconto</label>
                        {!! Form::text('price[0][discount_value]', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="checkbox">
                            <input type="hidden" name="price[0][import_price]" value="0">
                            <label for="ckbImportPrice"> {!! Form::checkbox('price[0][import_price]', 1, null, ['id' => 'ckbImportPrice', 'class' => '']) !!} Importa preço do ERP da People?</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
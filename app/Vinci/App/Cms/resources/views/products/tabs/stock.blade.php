<div class="tab-pane {{ currentTabActive('#productStock') }}" id="productStock">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-3">
                    <div class="form-group has-feedback">
                        <label>Estoque disponível</label>
                        {!! Form::text('stock', null, ['class' => 'form-control', 'placeholder' => 'Digite a quantidade em estoque']) !!}
                        <span class="fa fa-cubes form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="checkbox">
                            <input type="hidden" name="import_stock" value="0">
                            <label for="ckbImportStock"> {!! Form::checkbox('import_stock', 1, null, ['id' => 'ckbImportStock', 'class' => '']) !!} Importa estoque do ERP da People?</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
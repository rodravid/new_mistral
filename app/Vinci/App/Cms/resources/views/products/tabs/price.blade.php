<div class="tab-pane {{ currentTabActive('#productPrices') }}" id="productPrices">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">

                        <div class="form-group has-feedback">
                            <label for="txtName">Preço em dólar</label>
                            {!! Form::text('name', null, ['id' => 'txtName', 'class' => 'form-control', 'placeholder' => 'Digite o nome do produto']) !!}
                            <span class="fa fa-pencil form-control-feedback"></span>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div>
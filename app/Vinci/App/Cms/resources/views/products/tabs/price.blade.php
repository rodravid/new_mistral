<div class="tab-pane {{ currentTabActive('#productPrices') }}" id="productPrices">
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group">
                        <label>Canal de venda</label>
                        <input type="text" class="form-control" name="price[0][channel][id]" value="{{ old('price.0.channel.id', isset($product) ? $product->getDefaultChannel()->getName() : $channel->getName()) }}" disabled readonly>
                        <input type="hidden" name="price[0][channel][id]" value="{{ old('price.0.channel.id', isset($product) ? $product->getDefaultChannel()->getId() : $channel->getId()) }}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group has-feedback">
                        <label>Preço em dólar</label>
                        <input type="text" class="form-control" name="price[0][price]" value="{{ old('price.0.price', isset($product) ? $product->getPrice()->getPrice() : '') }}">
                        <span class="fa fa-dollar form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group has-feedback">
                        <label>Valor do dólar</label>
                        <input type="text" class="form-control" name="price[0][currency_amount]" value="{{ old('price.0.currency_amount', isset($product) ? $product->getPrice()->getCurrencyAmount() : '') }}">
                        <span class="fa fa-money form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group has-feedback">
                        <label>IPI %</label>
                        <input type="text" class="form-control" name="price[0][aliquot_ipi]" value="{{ old('price.0.aliquot_ipi', isset($product) ? $product->getPrice()->getAliquotIpi() : '') }}">
                        <span class="fa fa-percent form-control-feedback"></span>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group">
                        <label>Tipo de desconto</label>

                        <select name="price[0][discount_type]" class="form-control">

                            @foreach($discountTypes as $key => $value)

                                <option value="{{ $key }}" @if(old('price.0.discount_type', isset($product) ? $product->getPrice()->getDiscountType() : null) == $key) selected @endif>{{ $value }}</option>

                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-2">
                    <div class="form-group has-feedback">
                        <label>Valor do desconto</label>
                        <input type="text" class="form-control" name="price[0][discount_value]" value="{{ old('price.0.discount_value', isset($product) ? $product->getPrice()->getDiscountAmount() : '') }}">
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <div class="checkbox">
                            <input type="hidden" name="should_import_price" value="0">
                            <label for="ckbImportPrice">
                                <input type="checkbox" id="ckbImportPrice" name="should_import_price" value="1" @if(old('should_import_price', isset($product) ? $product->shouldImportPrice() : false)) checked @endif>
                                Importa preço do ERP da People?</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
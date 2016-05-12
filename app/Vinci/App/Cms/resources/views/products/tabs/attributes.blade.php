<div class="tab-pane {{ currentTabActive('#productAttributes') }}" id="productAttributes">
    <div class="row">
        <div class="col-xs-12">
            @foreach($type->getAttributes() as $key => $attribute)
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="txtName">{{ $attribute->getName() }}</label>

                            @if(isset($product) && $product->hasAttribute($attribute))

                                <input type="hidden" name="attributes[{{ $key }}][id]" value="{{ $product->getAttribute($attribute->getCode())->getId() }}">

                            @endif

                            <input type="hidden" name="attributes[{{ $key }}][attribute_id]" value="{{ $attribute->getId() }}">
                            {!! Form::input($attribute->getType(), 'attributes[' . $key . '][value]', isset($product) && $product->hasAttribute($attribute) ? $product->getAttribute($attribute->getCode())->getValue() : '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
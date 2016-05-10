<div class="tab-pane {{ currentTabActive('#productAttributes') }}" id="productAttributes">
    <div class="row">
        <div class="col-xs-12">
            @foreach($type->getAttributes() as $attribute)
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="txtName">{{ $attribute->getName() }}</label>
                            {!! Form::input($attribute->getType(), $attribute->getCode(), null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
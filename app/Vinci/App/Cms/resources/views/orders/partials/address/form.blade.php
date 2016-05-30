
<input type="hidden" name="addresses[{{ $address->getId() }}][id]" value="{{ $address->getId() }}">
<div class="col-xs-12">
    <div class="form-group pull-left">
        <div class="radio">
            <label for="addressType{{ $address->getId() }}R">
                <input type="radio" name="addresses[{{ $address->getId() }}][type]"
                       value="1"
                       id="addressType{{ $address->getId() }}R"
                       @if(old('addresses.' . $address->getId() . '.type') == 1) checked @endif>
                Residencial
            </label>&nbsp;&nbsp;&nbsp;
            <label for="addressType{{ $address->getId() }}C">
                <input type="radio" name="addresses[{{ $address->getId() }}][type]"
                       value="2"
                       id="addressType{{ $address->getId() }}C"
                       @if(old('addresses.' . $address->getId() . '.type') == 2) checked @endif>
                Comercial
            </label>&nbsp;&nbsp;&nbsp;
            <label for="addressType{{ $address->getId() }}O">
                <input type="radio" name="addresses[{{ $address->getId() }}][type]"
                       value="3"
                       id="addressType{{ $address->getId() }}O"
                       @if(old('addresses.' . $address->getId() . '.type') == 3) checked @endif>
                Outros
            </label>
        </div>
    </div>
</div>

<div class="col-xs-12">
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label>CEP</label>
                <input type="text" name="addresses[{{ $address->getId() }}][postal_code]" class="form-control"
                       value="{{ old('addresses.' . $address->getId() . '.postal_code') }}"
                       data-inputmask="'mask': '99999-999'"
                       data-mask data-postalcode
                       data-target-publicplace="#selectPublicPlace{{ $address->getId() }}"
                       data-target-address="#txtAddress{{ $address->getId() }}"
                       data-target-district="#txtDistrict{{ $address->getId() }}"
                       data-target-state="#selectState{{ $address->getId() }}"
                       data-target-city="#selectCity{{ $address->getId() }}"
                       data-target-number="#txtNumber{{ $address->getId() }}"
                       data-target-complement="#txtComplement{{ $address->getId() }}"
                >
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                <label>Identificador do local</label>
                <input type="text" name="addresses[{{ $address->getId() }}][nickname]" class="form-control" value="{{ old('addresses.' . $address->getId() . '.nickname') }}">
            </div>
        </div>
    </div>
</div>

<div class="col-lg-2">
    <div class="form-group">
        <label>Tipo</label>
        <select name="addresses[{{ $address->getId() }}][public_place]" id="selectPublicPlace{{ $address->getId() }}" class="form-control select2" style="width: 100%;" data-publicplace>
            <option value="1">Rua</option>
        </select>
    </div>
</div>

<div class="col-lg-8">
    <div class="form-group">
        <label>Endereço</label>
        <input type="text" name="addresses[{{ $address->getId() }}][address]" id="txtAddress{{ $address->getId() }}" class="form-control"
               value="{{ old('addresses.' . $address->getId() . '.address') }}" data-address>
    </div>
</div>

<div class="col-lg-2">
    <div class="form-group">
        <label>Número</label>
        <input type="text" name="addresses[{{ $address->getId() }}][number]" id="txtNumber{{ $address->getId() }}" class="form-control"
               value="{{ old('addresses.' . $address->getId() . '.number') }}">
    </div>
</div>

<div class="col-xs-12">
    <div class="form-group">
        <label>Complemento</label>
        <input type="text" name="addresses[{{ $address->getId() }}][complement]" id="txtComplement{{ $address->getId() }}" class="form-control"
               value="{{ old('addresses.' . $address->getId() . '.complement') }}">
    </div>
</div>

<div class="col-lg-3">
    <div class="form-group">
        <label>Bairro</label>
        <input type="text" name="addresses[{{ $address->getId() }}][district]" class="form-control" id="txtDistrict{{ $address->getId() }}"
               value="{{ old('addresses.' . $address->getId() . '.district') }}" data-dictrict>
    </div>
</div>

<div class="col-lg-3">
    <div class="form-group">
        <label>País</label>
        <select name="addresses[{{ $address->getId() }}][country]" class="form-control select2" style="width: 100%;" data-country>
            <option value="{{ $country->getId() }}">{{ $country->getName() }}</option>
        </select>
    </div>
</div>

<div class="col-lg-3">
    <div class="form-group">
        <label>Estado</label>
        <select name="addresses[{{ $address->getId() }}][state]" id="selectState{{ $address->getId() }}" class="form-control select2" style="width: 100%;" data-state data-target="#selectCity{{ $address->getId() }}" data-value="{{ old('addresses.' . $address->getId() . '.state') }}">
            <option value="">Selecione</option>
            @foreach($states as $state)
                <option value="{{ $state->getId() }}" @if($state->getId() == old('addresses.' . $address->getId() . '.state')) selected @endif>
                    {{ $state->getUf() }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-lg-3">
    <div class="form-group">
        <label>Cidade</label>
        <select name="addresses[{{ $address->getId() }}][city]" id="selectCity{{ $address->getId() }}" class="form-control select2" style="width: 100%;" data-city data-value="{{ old('addresses.' . $address->getId() . '.city') }}">
            <option value="">Selecione</option>
        </select>
    </div>
</div>

<div class="col-lg-6">
    <div class="form-group">
        <label>Ponto de referência</label>
        <input type="text" name="addresses[{{ $address->getId() }}][landmark]" class="form-control"
               value="{{ old('addresses.' . $address->getId() . '.landmark') }}">
    </div>
</div>

<div class="col-lg-6">
    <div class="form-group">
        <label>Receptor</label>
        <input type="text" name="addresses[{{ $address->getId() }}][receiver]" class="form-control"
               value="{{ old('addresses.' . $address->getId() . '.receiver') }}">
    </div>
</div>
<?php
    $address = new \Vinci\Domain\Customer\Address\Address();
    $r = new ReflectionObject($address);
    $property = $r->getProperty('id');
    $property->setAccessible(true);
    $property->setValue($address, 0);
?>
<div class="global-modal" ng-controller="AddressModalController">
    <div class="modal-larger modal-adress template1">
        <div class="content-modal">
            {!! Form::open() !!}
                <h2 class="title-modal-default">Novo Endereço</h2>
                <div class="user-data">
                    <ul class="list-form-register">
                        <li>
                            <ul class="list-type-radio-3cols">
                                <li>
                                    <label for="addressType{{ $address->getId() }}R">Residencial</label>
                                    <input type="radio" name="addresses[{{ $address->getId() }}][type]" class="physical-person"
                                           value="1"
                                           id="addressType{{ $address->getId() }}R"
                                           @if(old('addresses.' . $address->getId() . '.type') == 1) checked @endif>
                                </li>
                                <li>
                                    <label for="addressType{{ $address->getId() }}C">Comercial</label>
                                    <input type="radio" name="addresses[{{ $address->getId() }}][type]" class="physical-person"
                                           value="2"
                                           id="addressType{{ $address->getId() }}C"
                                           @if(old('addresses.' . $address->getId() . '.type') == 2) checked @endif>
                                </li>
                                <li>
                                    <label for="addressType{{ $address->getId() }}O">Outros</label>
                                    <input type="radio" name="addresses[{{ $address->getId() }}][type]" class="physical-person"
                                           value="3"
                                           id="addressType{{ $address->getId() }}O"
                                           @if(old('addresses.' . $address->getId() . '.type') == 3) checked @endif>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label for="txtNickname" class="label-input">Identificador do local *</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][nickname]" placeholder="Identificador do local (Ex: casa, trabalho)" id="txtNickname" class="type-addres input-register full" value="{{ old('addresses.' . $address->getId() . '.nickname') }}">
                        </li>
                        <li>
                            <label for="txtPostalCode" class="label-input">CEP</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][postal_code]" class="cep input-register half"
                                   id="txtPostalCode"
                                   value="{{ old('addresses.' . $address->getId() . '.postal_code') }}"
                                   placeholder="CEP"
                                   data-inputmask="'mask': '99999-999'"
                                   data-mask data-postalcode
                                   data-target-publicplace="#selectPublicPlace{{ $address->getId() }}"
                                   data-target-address="#txtAddress{{ $address->getId() }}"
                                   data-target-district="#txtDistrict{{ $address->getId() }}"
                                   data-target-state="#selectState{{ $address->getId() }}"
                                   data-target-city="#selectCity{{ $address->getId() }}"
                                   data-target-number="#txtNumber{{ $address->getId() }}"
                                   data-target-complement="#txtComplement{{ $address->getId() }}">

                            <div class="search-cep">
                                <p>Não sei o meu CEP.</p>
                                <a href="http://m.correios.com.br/movel/buscaCep.do" target="_blank">Faça a pesquisa
                                    aqui ></a>
                            </div>
                        </li>
                        <li>
                            <div class="select-standard half form-control-white">
                                <select name="addresses[{{ $address->getId() }}][public_place]" id="selectPublicPlace" data-publicplace>
                                    <option value="1">Rua</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <label for="txtAddress" class="label-input">Endereço *</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][address]" placeholder="Endereço *" id="txtAddress" class="input-register full"
                                   value="{{ old('addresses.' . $address->getId() . '.address') }}" data-address>
                        </li>
                        <li>
                            <label for="txtNumber" class="label-input">n°</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][number]" id="txtNumber" placeholder="n°" class="number input-register two-fields"
                                   value="{{ old('addresses.' . $address->getId() . '.number') }}">

                            <label for="txtComplement" class="label-input">Complemento</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][complement]" id="txtComplement" placeholder="Complemento" class="number input-register float-right two-fields"
                                   value="{{ old('addresses.' . $address->getId() . '.complement') }}">

                        </li>

                        <li>
                            <label for="txtDistrict" class="label-input">Bairro</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][district]" placeholder="Bairro" class="input-register full" id="txtDistrict"
                                   value="{{ old('addresses.' . $address->getId() . '.district') }}" data-dictrict>
                        </li>

                        <li>
                            <div class="select-standard half form-control-white">
                                <select class="" name="" id="">
                                    <option value="">Estado</option>
                                    <option value="AL">AC</option>
                                    <option value="AL">AL</option>
                                    <option value="AM">AM</option>
                                    <option value="AP">AP</option>
                                    <option value="BA">BA</option>
                                    <option value="CE">CE</option>
                                    <option value="DF">DF</option>
                                    <option value="ES">ES</option>
                                    <option value="GO">GO</option>
                                    <option value="MA">MA</option>
                                    <option value="MG">MG</option>
                                    <option value="MS">MS</option>
                                    <option value="MT">MT</option>
                                    <option value="PA">PA</option>
                                    <option value="PB">PB</option>
                                    <option value="PE">PE</option>
                                    <option value="PI">PI</option>
                                    <option value="PR">PR</option>
                                    <option value="RJ">RJ</option>
                                    <option value="RN">RN</option>
                                    <option value="RO">RO</option>
                                    <option value="RR">RR</option>
                                    <option value="RS">RS</option>
                                    <option value="SC">SC</option>
                                    <option value="SE">SE</option>
                                    <option value="SP">SP</option>
                                    <option value="TO">TO</option>
                                </select>
                            </div>
                        </li>

                        <li>
                            <div class="select-standard full form-control-white">
                                <select class="" name="" id="">
                                    <option value="">Cidade</option>

                                </select>
                            </div>
                        </li>

                        <li>
                            <label for="referencia" class="label-input">Referência para entrega</label>
                            <input class="input-register full" type="text" placeholder="Referência para entrega"
                                   id="referencia">
                        </li>
                    </ul>

                </div>
                <button type="submit" class="bt-default-full bt-big template1">Cadastrar <span class="arrow-link">></span></button>
            {!! Form::close() !!}
        </div>
        <a href="javascript:void(0)" class="close">X</a>
    </div>
</div>
<div class="overlay"></div>
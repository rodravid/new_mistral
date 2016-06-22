<div class="global-modal" ng-controller="AddressModalController">
    <div class="modal-larger modal-adress template1">
        <div class="content-modal">
            {!! Form::open(['route' => $address->getId() > 0 ? ['api.customers.addresses.update', $address->getId()] : 'api.customers.addresses.store', 'method' => 'POST', 'id' => 'frmNewAddress']) !!}
                <input type="hidden" name="addresses[{{ $address->getId() }}][id]" value="{{ $address->getId() }}">
                <input type="hidden" name="addresses[{{ $address->getId() }}][country]" value="{{ \Vinci\Domain\Address\Country\Country::BRAZIL }}">
                <input type="hidden" name="main_address" value="0">
                <input type="hidden" name="customer" value="{{ $loggedUser->getId() }}">
                <h2 class="title-modal-default">@if($address->getId() > 0) Atualizar endereço @else Novo Endereço @endif</h2>
                <div class="user-data">
                    <ul class="list-form-register">
                        <li>
                            <ul class="list-type-radio-3cols">
                                <li>
                                    <label for="addressType{{ $address->getId() }}R">Residencial</label>
                                    <input type="radio" name="addresses[{{ $address->getId() }}][type]" class="physical-person"
                                           value="1"
                                           id="addressType{{ $address->getId() }}R"
                                           @if(old('addresses.' . $address->getId() . '.type', ($address->getId() > 0 ? $address->getType()->getId() : null)) == 1) checked @endif>
                                </li>
                                <li>
                                    <label for="addressType{{ $address->getId() }}C">Comercial</label>
                                    <input type="radio" name="addresses[{{ $address->getId() }}][type]" class="physical-person"
                                           value="2"
                                           id="addressType{{ $address->getId() }}C"
                                           @if(old('addresses.' . $address->getId() . '.type', ($address->getId() > 0 ? $address->getType()->getId() : null)) == 2) checked @endif>
                                </li>
                                <li>
                                    <label for="addressType{{ $address->getId() }}O">Outros</label>
                                    <input type="radio" name="addresses[{{ $address->getId() }}][type]" class="physical-person"
                                           value="3"
                                           id="addressType{{ $address->getId() }}O"
                                           @if(old('addresses.' . $address->getId() . '.type', ($address->getId() > 0 ? $address->getType()->getId() : null)) == 3) checked @endif>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <label for="txtNickname" class="label-input">Identificador do local *</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][nickname]" placeholder="Identificador do local (Ex: casa, trabalho)" id="txtNickname" class="type-addres input-register full" value="{{ old('addresses.' . $address->getId() . '.nickname', ($address->getId() > 0 ? $address->getNickname() : null)) }}">
                        </li>
                        <li>
                            <label for="txtPostalCode" class="label-input">CEP</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][postal_code]" class="cep input-register half"
                                   id="txtPostalCode"
                                   value="{{ old('addresses.' . $address->getId() . '.postal_code', ($address->getId() > 0 ? $address->getPostalCode() : null)) }}"
                                   placeholder="CEP"
                                   cep
                                   data-mask data-postalcode
                                   data-target-publicplace="#selectPublicPlace"
                                   data-target-address="#txtAddress"
                                   data-target-district="#txtDistrict"
                                   data-target-state="#selectState"
                                   data-target-city="#selectCity"
                                   data-target-number="#txtNumber"
                                   data-target-complement="#txtComplement">

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
                                   value="{{ old('addresses.' . $address->getId() . '.address', ($address->getId() > 0 ? $address->getAddress() : null)) }}" data-address>
                        </li>
                        <li>
                            <label for="txtNumber" class="label-input">n°</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][number]" id="txtNumber" placeholder="n°" class="number input-register two-fields"
                                   value="{{ old('addresses.' . $address->getId() . '.number', ($address->getId() > 0 ? $address->getNumber() : null)) }}">

                            <label for="txtComplement" class="label-input">Complemento</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][complement]" id="txtComplement" placeholder="Complemento" class="number input-register float-right two-fields"
                                   value="{{ old('addresses.' . $address->getId() . '.complement', ($address->getId() > 0 ? $address->getComplement() : null)) }}">

                        </li>

                        <li>
                            <label for="txtDistrict" class="label-input">Bairro</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][district]" placeholder="Bairro" class="input-register full" id="txtDistrict"
                                   value="{{ old('addresses.' . $address->getId() . '.district', ($address->getId() > 0 ? $address->getDistrict() : null)) }}" data-dictrict>
                        </li>

                        <li>
                            <div class="select-standard half form-control-white">
                                <select name="addresses[{{ $address->getId() }}][state]" id="selectState" data-state data-target="#selectCity" data-value="{{ old('addresses.' . $address->getId() . '.state', ($address->getId() > 0 ? $address->getState()->getId() : null)) }}">
                                    <option value="">Selecione</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->getId() }}" @if($state->getId() == old('addresses.' . $address->getId() . '.state', ($address->getId() > 0 ? $address->getState()->getId() : null))) selected @endif>
                                            {{ $state->getUf() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </li>

                        <li>
                            <div class="select-standard full form-control-white">
                                <select name="addresses[{{ $address->getId() }}][city]" id="selectCity" data-city data-value="{{ old('addresses.' . $address->getId() . '.city', ($address->getId() > 0 ? $address->getCity()->getId() : null)) }}">

                                    @if ($address->getId() > 0)

                                        @foreach($cities as $city)
                                            <option value="{{ $city->getId() }}" @if($city->getId() == old('addresses.' . $address->getId() . '.city', $address->getCity()->getId())) selected @endif>
                                                {{ $city->getName() }}
                                            </option>
                                        @endforeach

                                    @else
                                        <option value="">Selecione</option>
                                    @endif
                                </select>
                            </div>
                        </li>

                        <li>
                            <label for="txtLandmark" class="label-input">Referência para entrega</label>
                            <input type="text" name="addresses[{{ $address->getId() }}][landmark]" placeholder="Referência para entrega" id="txtLandmark" class="input-register full"
                                   value="{{ old('addresses.' . $address->getId() . '.landmark', ($address->getId() > 0 ? $address->getLandmark() : null)) }}">
                        </li>
                    </ul>

                </div>

                <div class="error-message"></div>

                <button type="submit" class="bt-default-full bt-big template1">@if($address->getId() > 0) Salvar @else Cadastrar @endif <span class="arrow-link">></span></button>
            {!! Form::close() !!}
        </div>
        <a href="javascript:void(0)" class="close">X</a>
    </div>
</div>
<div class="overlay"></div>

<script src="{{ asset('assets/common/js/address-autocomplete.js') }}" type="text/javascript"></script>
<script type="text/javascript">

        $(document).ready(function() {

            $('#frmNewAddress').bind('submit', function(e) {

                var $form = $(this);

                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response) {

                        if (response.success) {

                            $('.global-modal, .overlay').fadeOut(300, function() {

                                swal('Pronto!', response.message, 'success');

                                setTimeout(function() {

                                    window.location.reload();

                                }, 1000);

                            });

                        } else {

                            $('.error-message').text(response.message);

                        }

                    }
                });

                e.preventDefault();
            });


        });

    </script>
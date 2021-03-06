<div class="row" ng-app="customerForm" ng-controller="CustomerFormController as formCtrl">

    <div class="col-xs-12">
        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
            <li class="{{ currentTabActive('#customer-data', 'active', true) }}"><a href="#customer-data" data-toggle="tab" aria-expanded="true"><i class="fa fa-user"></i> Dados do cliente</a></li>
            <li class="{{ currentTabActive('#customer-addresses') }}"><a href="#customer-addresses" data-toggle="tab" aria-expanded="false"><i class="fa fa-flag-checkered"></i> Endereços</a></li>
            @if($loggedUser->isSuperAdmin())
            <li class="{{ currentTabActive('#customer-integration') }}"><a href="#customer-integration" data-toggle="tab" aria-expanded="false"><i class="fa fa-cog"></i> Integração ERP</a></li>
            @endif
        </ul>
        <div class="tab-content">
            <input type="hidden" name="current-tab" id="currentTab" value="{{ old('current-tab', '#customer-data') }}">
            <div class="tab-pane {{ currentTabActive('#customer-data', 'active', true) }}" id="customer-data">
                <div class="row">

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="txtUserName">Nome</label>
                            {!! Form::text('name', null, ['id' => 'txtUserName', 'class' => 'form-control', 'placeholder' => 'Digite o nome']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="txtUserEmail">E-mail</label>
                            {!! Form::text('email', null, ['id' => 'txtUserEmail', 'class' => 'form-control', 'placeholder' => 'Digite o e-mail']) !!}
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-2">
                        <div class="form-group">
                            <label>Tipo de pessoa</label>
                            <div class="radio">
                                <label for="radioPersonTypeIndividual">
                                    {!! Form::radio('customerType', \Vinci\Domain\Customer\CustomerType::INDIVIDUAL, null, ['id' => 'radioPersonTypeIndividual', 'ng-model' => 'customerType']) !!}
                                    Física
                                </label>&nbsp;&nbsp;&nbsp;
                                <label for="radioPersonTypeCompany">
                                    {!! Form::radio('customerType', \Vinci\Domain\Customer\CustomerType::COMPANY, null, ['id' => 'radioPersonTypeCompany', 'ng-model' => 'customerType']) !!}
                                    Jurídica
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-10" ng-show="customerType == 1">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="selectGender">Sexo</label>
                                    {!! Form::select('gender', [\Vinci\Domain\Common\Gender::MALE => 'Masculino', \Vinci\Domain\Common\Gender::FEMALE => 'Feminino'], null, ['id' => 'selectGender', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="txtBirthday">Data de nascimento</label>
                                    {!! Form::text('birthday', isset($customer) && $customer->getBirthday() ? $customer->getBirthday()->format('d/m/Y') : null, ['id' => 'txtBirthday', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="txtCpf">CPF</label>
                                    {!! Form::text('cpf', null, ['id' => 'txtCpf', 'class' => 'form-control', 'data-inputmask' => '\'mask\': \'999.999.999-99\'', 'data-mask', 'maxlength' => 14]) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="txtRg">RG</label>
                                    {!! Form::text('rg', null, ['id' => 'txtRg', 'class' => 'form-control', 'maxlength' => 15]) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="txtIssuingBody">Órgão emissor</label>
                                    {!! Form::text('issuingBody', null, ['id' => 'txtIssuingBody', 'class' => 'form-control', 'maxlength' => 15]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-md-10 ng-hide" ng-show="customerType == 2">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="txtCompanyName">Nome da empresa</label>
                                    {!! Form::text('companyName', null, ['id' => 'txtCompanyName', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="txtCompanyContact">Responsável</label>
                                    {!! Form::text('companyContact', null, ['id' => 'txtCompanyContact', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="txtCnpj">CNPJ</label>
                                    {!! Form::text('cnpj', null, ['id' => 'txtCnpj', 'class' => 'form-control', 'data-inputmask' => '\'mask\': \'99.999.999/9999-99\'', 'data-mask']) !!}
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="txtIE">Inscrição estadual</label>
                                    {!! Form::text('stateRegistration', null, ['id' => 'txtIE', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="txtPhone">Telefone de contato</label>
                                    {!! Form::text('phone', null, ['id' => 'txtPhone', 'class' => 'form-control', 'data-inputmask' => '\'mask\': \'(99) 9999-9999[9]\'', 'data-mask']) !!}
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="txtcellPhone">Celular</label>
                                    {!! Form::text('cellPhone', null, ['id' => 'txtcellPhone', 'class' => 'form-control', 'data-inputmask' => '\'mask\': \'(99) 9999-9999[9]\'', 'data-mask']) !!}
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="txtCommercialPhone">Telefone comercial</label>
                                    {!! Form::text('commercialPhone', null, ['id' => 'txtCommercialPhone', 'class' => 'form-control', 'data-inputmask' => '\'mask\': \'(99) 9999-9999[9]\'', 'data-mask']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(isset($customer))
                        <div class="col-xs-12">
                            <div class="form-group">
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm" ng-click="toggleChangePassword()">Alterar senha</a>
                            </div>
                        </div>
                    @endif

                    <div class="col-xs-12 @if(isset($customer)) ng-hide @endif" @if(isset($customer)) ng-show="changePassword" @endif>
                        <div class="row">
                            <div class="col-xs-12 col-lg-6">
                                <div class="form-group has-feedback">
                                    <label for="txtUserPassword">Nova senha</label>
                                    {!! Form::password('password', ['id' => 'txtUserPassword', 'class' => 'form-control', 'placeholder' => 'Digite a nova senha']) !!}
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                            </div>

                            <div class="col-xs-12 col-lg-6">
                                <div class="form-group has-feedback">
                                    <label for="txtUserPasswordConfirmation">Confirmação da senha</label>
                                    {!! Form::password('password_confirmation', ['id' => 'txtUserPasswordConfirmation', 'class' => 'form-control', 'placeholder' => 'Digite a senha novamente']) !!}
                                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="tab-pane {{ currentTabActive('#customer-addresses') }}" id="customer-addresses">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box-addresses">
                            <div class="row">
                                @if (isset($customer))
                                    <div class="col-xs-12">
                                        <a href="javascript:void(0);" class="btn btn-primary" style="margin-bottom: 20px;" data-toggle="modal" data-target="#modalNewAddress">Novo endereço</a>
                                    </div>
                                    @foreach($customer->getAddresses() as $address)
                                        <div class="col-xs-12 address-box" data-id="{{ $address->getId() }}">
                                            <input type="hidden" name="addresses[{{ $address->getId() }}][id]" value="{{ $address->getId() }}">
                                            <div class="box box-default">
                                                <div class="box-header with-border">
                                                    <h3 class="box-title"><i class="fa fa-flag-checkered"></i> {{ $address->getNickname() }}</h3>
                                                    <div class="box-tools pull-right">
                                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                                    </div>
                                                </div>
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-xs-12">
                                                            <div class="form-group pull-left">
                                                                <div class="radio">
                                                                    <label for="addressType{{ $address->getId() }}R">
                                                                        <input type="radio" name="addresses[{{ $address->getId() }}][type]"
                                                                               value="1"
                                                                               id="addressType{{ $address->getId() }}R"
                                                                                @if(old('addresses.' . $address->getId() . '.type') == 1 || $address->getType()->getId() == 1) checked @endif>
                                                                        Residencial
                                                                    </label>&nbsp;&nbsp;&nbsp;
                                                                    <label for="addressType{{ $address->getId() }}C">
                                                                        <input type="radio" name="addresses[{{ $address->getId() }}][type]"
                                                                               value="2"
                                                                               id="addressType{{ $address->getId() }}C"
                                                                               @if(old('addresses.' . $address->getId() . '.type') == 2 || $address->getType()->getId() == 2) checked @endif>
                                                                        Comercial
                                                                    </label>&nbsp;&nbsp;&nbsp;
                                                                    <label for="addressType{{ $address->getId() }}O">
                                                                        <input type="radio" name="addresses[{{ $address->getId() }}][type]"
                                                                               value="3"
                                                                               id="addressType{{ $address->getId() }}O"
                                                                               @if(old('addresses.' . $address->getId() . '.type') == 3 || $address->getType()->getId() == 3) checked @endif>
                                                                        Outros
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm pull-right" ng-click="removeAddressBox({{ $address->getId() }})"><i class="fa fa-minus-circle"></i> Remover endereço</a>
                                                        </div>

                                                        <div class="col-xs-12">
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>CEP</label>
                                                                        <input type="text" name="addresses[{{ $address->getId() }}][postal_code]" class="form-control"
                                                                               value="{{ old('addresses.' . $address->getId() . '.postal_code', $address->getPostalCode()) }}"
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
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <label>Identificador do local</label>
                                                                        <input type="text" name="addresses[{{ $address->getId() }}][nickname]" class="form-control"
                                                                               value="{{ old('addresses.' . $address->getId() . '.nickname', $address->getNickname()) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>Tipo</label>
                                                                <select name="addresses[{{ $address->getId() }}][public_place]" id="selectPublicPlace{{ $address->getId() }}" class="form-control select2" style="width: 100%;" data-publicplace>
                                                                    @foreach($publicPlaces as $publicPlace)
                                                                        <option value="{{ $publicPlace->getId() }}" @if($publicPlace->getId() == old('addresses.0.public_place', $address->getPublicPlace()->getId())) selected @endif>{{ $publicPlace->getTitle() }}</option>
                                                                    @endforeach
                                                                </select>
                                                                {{--<select name="addresses[{{ $address->getId() }}][public_place]" id="selectPublicPlace{{ $address->getId() }}" class="form-control select2" style="width: 100%;" data-publicplace>--}}
                                                                {{--<option value="1">Rua</option>--}}
                                                                {{--</select>--}}
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-8">
                                                            <div class="form-group">
                                                                <label>Endereço</label>
                                                                <input type="text" name="addresses[{{ $address->getId() }}][address]" id="txtAddress{{ $address->getId() }}" class="form-control"
                                                                       value="{{ old('addresses.' . $address->getId() . '.address', $address->getAddress()) }}" data-address>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <label>Número</label>
                                                                <input type="text" name="addresses[{{ $address->getId() }}][number]" id="txtNumber{{ $address->getId() }}" class="form-control"
                                                                       value="{{ old('addresses.' . $address->getId() . '.number', $address->getNumber()) }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-xs-12">
                                                            <div class="form-group">
                                                                <label>Complemento</label>
                                                                <input type="text" name="addresses[{{ $address->getId() }}][complement]" id="txtComplement{{ $address->getId() }}" class="form-control"
                                                                       value="{{ old('addresses.' . $address->getId() . '.complement', $address->getComplement()) }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Bairro</label>
                                                                <input type="text" name="addresses[{{ $address->getId() }}][district]" class="form-control" id="txtDistrict{{ $address->getId() }}"
                                                                       value="{{ old('addresses.' . $address->getId() . '.district', $address->getDistrict()) }}" data-dictrict>
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
                                                                <select name="addresses[{{ $address->getId() }}][state]" id="selectState{{ $address->getId() }}" class="form-control select2" style="width: 100%;" data-state data-target="#selectCity{{ $address->getId() }}" data-value="{{ old('addresses.' . $address->getId() . '.state', $address->getState()->getId()) }}">
                                                                    <option value=""></option>
                                                                    @foreach($states as $state)
                                                                        <option value="{{ $state->getId() }}" @if($state->getId() == old('addresses.' . $address->getId() . '.state') || $state->getId() == $address->getState()->getId()) selected @endif>
                                                                            {{ $state->getUf() }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <label>Cidade</label>
                                                                <select name="addresses[{{ $address->getId() }}][city]" id="selectCity{{ $address->getId() }}" class="form-control select2" style="width: 100%;" data-city data-value="{{ old('addresses.' . $address->getId() . '.city', $address->getCity()->getId()) }}">
                                                                    <option value="">Selecione a cidade</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Ponto de referência</label>
                                                                <input type="text" name="addresses[{{ $address->getId() }}][landmark]" class="form-control"
                                                                       value="{{ old('addresses.' . $address->getId() . '.landmark', $address->getLandmark()) }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label>Receptor</label>
                                                                <input type="text" name="addresses[{{ $address->getId() }}][receiver]" class="form-control"
                                                                       value="{{ old('addresses.' . $address->getId() . '.receiver', $address->getReceiver()) }}">
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="radio">
                                                                <label for="radionMainAddress{{ $address->getId() }}">
                                                                    <input type="radio" name="main_address"
                                                                           value="{{ $address->getId() }}"
                                                                           id="radionMainAddress{{ $address->getId() }}"
                                                                           @if($address->getId() == old('main_address', $address->getId() == $customer->getMainAddress()->getId())) checked @endif>
                                                                    Endereço principal
                                                                </label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    @include('cms::customers.partials.address.new')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($loggedUser->isSuperAdmin())
                @include('cms::customers.tabs.integration')
            @endif
        </div>
    </div>

</div>

@section('scripts')
    @parent

    <script type="text/javascript" src="{{ asset('assets/common/js/address-autocomplete.js') }}"></script>

    <script type="text/javascript">

        angular.module('customerForm', [])
                .controller('CustomerFormController', function($scope) {

                    $scope.customerType = '{{ old('customerType', isset($customer) ? $customer->getCustomerType() : 1) }}';
                    $scope.changePassword = false;

                    $scope.toggleChangePassword = function() {

                        if (! $scope.changePassword) {
                            $scope.changePassword = true;

                            $('#txtUserPassword').val('');
                            $('#txtUserPasswordConfirmation').val('');
                        } else {
                            $scope.changePassword = false;
                        }

                    };

                    $scope.removeAddressBox = function(addressId) {
                        $('.address-box[data-id="' + addressId + '"]').slideUp(300, function() {
                            $(this).remove();
                            $('input[name="main_address"]').first().prop('checked', true);
                        });
                    };

                });


        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");

            $('#currentTab').val(target);
        });

    </script>

@endsection
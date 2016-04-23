<div class="row" ng-app="customerForm" ng-controller="CustomerFormController as formCtrl">

    <div class="col-xs-12">
        <ul class="nav nav-tabs" style="margin-bottom: 20px;">
            <li class="@if(old('current-tab') == '#customer-data' || old('current-tab') == null) active @endif"><a href="#customer-data" data-toggle="tab" aria-expanded="true">Dados do cliente</a></li>
            <li class="@if(old('current-tab') == '#customer-addresses') active @endif"><a href="#customer-addresses" data-toggle="tab" aria-expanded="false">Endereços</a></li>
        </ul>
        <div class="tab-content">
            <input type="hidden" name="current-tab" id="currentTab" value="{{ old('current-tab', '#customer-data') }}">
            <div class="tab-pane @if(old('current-tab') == '#customer-data' || old('current-tab') == null) active @endif" id="customer-data">
                <div class="row">

                    <div class="col-xs-12">
                        <div class="form-group has-feedback">
                            <label for="txtUserName">Nome</label>
                            {!! Form::text('name', null, ['id' => 'txtUserName', 'class' => 'form-control', 'placeholder' => 'Digite o nome']) !!}
                            <span class="fa fa-pencil form-control-feedback"></span>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group has-feedback">
                            <label for="txtUserEmail">E-mail</label>
                            {!! Form::text('email', null, ['id' => 'txtUserEmail', 'class' => 'form-control', 'placeholder' => 'Digite o e-mail']) !!}
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
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
                                    {!! Form::text('birthday', $customer->getBirthday()->format('d/m/Y'), ['id' => 'txtBirthday', 'class' => 'form-control']) !!}
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

                    <div class="col-xs-12">
                        <div class="form-group">
                            <a href="javascript:void(0);" class="btn btn-primary btn-sm" ng-click="toggleChangePassword()">Alterar senha</a>
                        </div>
                    </div>

                    <div class="col-xs-12 ng-hide" ng-show="changePassword">
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

            <div class="tab-pane @if(old('current-tab') == '#customer-addresses') active @endif" id="customer-addresses">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box-addresses">
                            <div class="row">
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
                                                                           value="{{ old('addresses.' . $address->getId() . '.postal_code', $address->getPostalCode()) }}" data-inputmask="'mask': '99999-999'" data-mask>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label>Apelido</label>
                                                                    <input type="text" name="addresses[{{ $address->getId() }}][nickname]" class="form-control"
                                                                           value="{{ old('addresses.' . $address->getId() . '.nickname', $address->getNickname()) }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label>Tipo</label>
                                                            <select name="addresses[{{ $address->getId() }}][public_place]" class="form-control select2" style="width: 100%;">
                                                                <option value="1">Rua</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-8">
                                                        <div class="form-group">
                                                            <label>Logradouro</label>
                                                            <input type="text" name="addresses[{{ $address->getId() }}][address]" class="form-control"
                                                                   value="{{ old('addresses.' . $address->getId() . '.address', $address->getAddress()) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label>Número</label>
                                                            <input type="text" name="addresses[{{ $address->getId() }}][number]" class="form-control"
                                                                   value="{{ old('addresses.' . $address->getId() . '.number', $address->getNumber()) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-xs-12">
                                                        <div class="form-group">
                                                            <label>Complemento</label>
                                                            <input type="text" name="addresses[{{ $address->getId() }}][complement]" class="form-control"
                                                                   value="{{ old('addresses.' . $address->getId() . '.complement', $address->getComplement()) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Bairro</label>
                                                            <input type="text" name="addresses[{{ $address->getId() }}][district]" class="form-control"
                                                                   value="{{ old('addresses.' . $address->getId() . '.district', $address->getDistrict()) }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>País</label>
                                                            <select name="addresses[{{ $address->getId() }}][country]" class="form-control select2" style="width: 100%;">
                                                                <option value="1">Brasil</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Estado</label>
                                                            <select name="addresses[{{ $address->getId() }}][state]" class="form-control select2" style="width: 100%;">
                                                                <option value="1">SP</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label>Cidade</label>
                                                            <select name="addresses[{{ $address->getId() }}][city]" class="form-control select2" style="width: 100%;">
                                                                <option value="1">Bragança Paulista</option>
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

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('scripts')
    @parent

    <script type="text/javascript">

        angular.module('customerForm', [])
                .controller('CustomerFormController', function($scope) {

                    $scope.customerType = '{{ old('customerType', $customer->getCustomerType()) }}';
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
                        });
                    };

                });


        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href");

            $('#currentTab').val(target);
        });

    </script>

@endsection
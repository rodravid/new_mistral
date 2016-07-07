@extends('website::layouts.master')

@section('content')

    <div class="header-internal template1-bg">
        @include('website::layouts.menu')
        <div class="row">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="/"><span>Início</span></a> >
                </li>

                <li class="breadcrumb-item">
                    <span>Cadastro</span>
                </li>
            </ul>

            <h1 class="internal-subtitle">Cadastro</h1>

        </div>
    </div>

    <div class="row" ng-controller="RegisterController">

        <header class="header-content-internal">

            <div class="container-total-products">
                <span class="title-internal-15">Para criar a sua conta basta preencher os dados abaixo</span>
                <p>* Campos obrigatórios</p>
            </div>

        </header>

        <article class="wrap-content-register">

            @if($errors->has())
                <ul class="error-message">
                    @if($errors->count() > 10)
                        <li>{{ $errors->first() }}</li>
                    @else
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    @endif
                </ul>
            @endif

            {!! Form::open(['route' => 'register.store', 'method' => 'post']) !!}

                <header class="header-content-internal">
                    <ul class="list-type-buyer" ng-init="customerType = {{ old('customerType', 1) }}; selectedAddressType = {{ old('addresses.0.type', 1) }}; onCustomerTypeChange()">
                        <li>
                            <label for="radioPersonTypeIndividual">Pessoa Física</label>
                            {!! Form::radio('customerType', \Vinci\Domain\Customer\CustomerType::INDIVIDUAL, null, ['id' => 'radioPersonTypeIndividual', 'ng-model' => 'customerType', 'class' => 'legal-person', 'ng-change' => 'onCustomerTypeChange()']) !!}
                        </li>
                        <li>
                            <label for="radioPersonTypeCompany">Pessoa Jurídica</label>
                            {!! Form::radio('customerType', \Vinci\Domain\Customer\CustomerType::COMPANY, null, ['id' => 'radioPersonTypeCompany', 'ng-model' => 'customerType', 'class' => 'legal-person', 'ng-change' => 'onCustomerTypeChange()']) !!}
                        </li>
                    </ul>
                </header>

                <div class="col-register1 template1">

                    <div class="user-data">
                        <h2 class="title-form">Dados de acesso *</h2>
                        <ul class="list-form-register">
                            <li>
                                <label for="email" class="label-input">E-mail *</label>
                                {!! Form::email('email', null, ['id' => 'email', 'placeholder' => 'E-mail *', 'class' => 'email input-register full ' . ($errors->has('email') ? 'error-field' : '')]) !!}
                            </li>
                            <li>
                                <label for="password" class="label-input left0">Senha *</label>
                                {!! Form::password('password', ['id' => 'password', 'placeholder' => 'Senha *', 'class' => 'email float-left input-register half ' . ($errors->has('password') ? 'error-field' : '')]) !!}
                                <p class="characters-pass">Mínimo 6 caracteres</p>
                            </li>
                            <li>
                                <label for="passwordConfirmation" class="label-input left0">Confirmar senha *</label>
                                {!! Form::password('password_confirmation', ['id' => 'passwordConfirmation', 'placeholder' => 'Confirmar senha *', 'class' => 'email float-left input-register half ' . ($errors->has('password') ? 'error-field' : '')]) !!}
                                <p class="characters-pass">Mínimo 6 caracteres</p>
                            </li>
                        </ul>

                        <div class="" id="person" ng-show="customerType == 1">
                            <h2 class="title-form">Dados Pessoais *</h2>
                            <ul class="list-form-register">
                                <li>
                                    <label for="name" class="label-input">Nome completo *</label>
                                    {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Nome completo *', 'class' => 'email input-register full ' . ($errors->has('name') ? 'error-field' : '')]) !!}
                                </li>
                                <li>
                                    <label for="cpf" class="label-input">CPF *</label>
                                    {!! Form::text('cpf', null, ['id' => 'cpf', 'placeholder' => 'CPF *', 'class' => 'input-register full ' . ($errors->has('cpf') ? 'error-field' : ''), 'ui-br-cpf-mask', 'ng-model' => 'cpf']) !!}
                                </li>
                                <li>
                                    <label for="rg" class="label-input">RG</label>
                                    {!! Form::text('rg', null, ['id' => 'rg', 'placeholder' => 'RG', 'class' => 'input-register full ' . ($errors->has('rg') ? 'error-field' : '')]) !!}
                                </li>
                                <li>
                                    <label for="issuingBody" class="label-input">Orgão Emissor</label>
                                    {!! Form::text('issuingBody', null, ['id' => 'issuingBody', 'placeholder' => 'Órgão emissor', 'class' => 'input-register full ' . ($errors->has('issuingBody') ? 'error-field' : '')]) !!}
                                </li>
                                <li>
                                    <div class="select-standard form-control-white {{ $errors->has('gender') ? 'error-field' : '' }}">
                                        {!! Form::select('gender', ['' => 'Sexo *', \Vinci\Domain\Common\Gender::MALE => 'Masculino', \Vinci\Domain\Common\Gender::FEMALE => 'Feminino'], null, ['id' => 'selectGender']) !!}
                                    </div>
                                </li>
                                <li>
                                    <label for="txtBirthday" class="label-input">Data de Nascimento *</label>
                                    {!! Form::text('birthday', null, ['id' => 'txtBirthday', 'placeholder' => 'Data de Nascimento *', 'class' => 'birth-date input-register seventy ' . ($errors->has('birthday') ? 'error-field' : ''), 'date']) !!}
                                </li>
                            </ul>
                        </div>

                        <div class="" id="company" ng-show="customerType == 2">
                            <h2 class="title-form">Dados Empresa *</h2>
                            <ul class="list-form-register">
                                <li>
                                    <label for="companyName" class="label-input">Nome da empresa *</label>
                                    {!! Form::text('companyName', null, ['id' => 'companyName', 'placeholder' => 'Nome da empresa *', 'class' => 'input-register full ' . ($errors->has('companyName') ? 'error-field' : '')]) !!}
                                </li>
                                <li>
                                    <label for="companyContact" class="label-input">Responsável</label>
                                    {!! Form::text('companyContact', null, ['id' => 'companyContact', 'placeholder' => 'Responsável', 'class' => 'input-register full ' . ($errors->has('companyContact') ? 'error-field' : '')]) !!}
                                </li>
                                <li>
                                    <label for="cnpj" class="label-input">CNPJ *</label>
                                    {!! Form::text('cnpj', null, ['id' => 'cnpj', 'placeholder' => 'CNPJ *', 'class' => 'input-register full ' . ($errors->has('cnpj') ? 'error-field' : ''), 'cnpj']) !!}
                                </li>
                                <li>
                                    <label for="stateRegistration" class="label-input">IE *</label>
                                    {!! Form::text('stateRegistration', null, ['id' => 'stateRegistration', 'placeholder' => 'IE *', 'class' => 'input-register full ' . ($errors->has('stateRegistration') ? 'error-field' : '')]) !!}
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-register2 template1">

                    <div class="user-address">
                        <h2 class="title-form">Endereço de Entrega *</h2>
                        <ul class="list-form-register">
                            <input type="hidden" name="addresses[0][id]" value="0">
                            <input type="hidden" name="addresses[0][country]" value="{{ \Vinci\Domain\Address\Country\Country::BRAZIL }}">
                            <input type="hidden" name="main_address" value="0">
                            <li>
                                <ul class="list-type-radio-3cols">
                                    <li ng-hide="customerType == 2">
                                        <label for="residencial">Residencial</label>
                                        {!! Form::radio('addresses[0][type]', 1, null, ['class' => 'physical-person', 'id' => 'residencial', 'ng-model' => 'addressType']) !!}
                                    </li>
                                    <li>
                                        <label for="comercial">Comercial</label>
                                        {!! Form::radio('addresses[0][type]', 2, null, ['class' => 'physical-person', 'id' => 'comercial', 'ng-model' => 'addressType']) !!}
                                    </li>
                                    <li ng-hide="customerType == 2">
                                        <label for="other">Outros</label>
                                        {!! Form::radio('addresses[0][type]', 3, null, ['class' => 'physical-person', 'id' => 'other', 'ng-model' => 'addressType']) !!}
                                    </li>
                                </ul>
                            </li>

                            <li ng-show="addressType == 3">
                                <label for="type-addres" class="label-input">Identificador do local (Ex: casa, trabalho) *</label>
                                {!! Form::text('addresses[0][nickname]', null, ['id' => 'addressNickname', 'placeholder' => 'Identificador do local (Ex: casa, trabalho) *', 'class' => 'input-register full ' . ($errors->has('addresses.0.nickname') ? 'error-field' : '')]) !!}
                            </li>
                            <li>
                                <label for="cep" class="label-input">CEP *</label>

                                <input type="text" name="addresses[0][postal_code]" class="input-register half {{ $errors->has('addresses.0.postal_code') ? 'error-field' : '' }}" placeholder="CEP *"
                                       value="{{ old('addresses.0.postal_code') }}"
                                       cep
                                       data-postalcode
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
                                <div class="select-standard half form-control-white {{ $errors->has('addresses.0.public_place') ? 'error-field' : '' }}">
                                    <select name="addresses[0][public_place]" id="selectPublicPlace" data-publicplace>
                                        <option value="">Selecione o tipo de logradouro</option>
                                        @foreach($publicPlaces as $publicPlace)
                                            <option value="{{ $publicPlace->getId() }}" @if($publicPlace->getId() == old('addresses.0.public_place')) selected @endif>{{ $publicPlace->getTitle() }}</option>
                                        @endforeach
                                    </select>
                                    {{--{!! Form::select('addresses[0][public_place]', ['1' => 'Rua', '2' => 'Avenida'], null, ['id' => 'selectPublicPlace', 'data-publicplace']) !!}--}}

                                </div>
                            </li>
                            <li>
                                <label for="txtAddress" class="label-input">Endereço *</label>
                                {!! Form::text('addresses[0][address]', null, ['id' => 'txtAddress', 'placeholder' => 'Endereço *', 'class' => 'input-register full ' . ($errors->has('addresses.0.address') ? 'error-field' : '')]) !!}
                            </li>
                            <li>
                                <label for="txtNumber" class="label-input">N° *</label>
                                {!! Form::text('addresses[0][number]', null, ['id' => 'txtNumber', 'placeholder' => 'N° *', 'class' => 'number input-register two-fields ' . ($errors->has('addresses.0.number') ? 'error-field' : '')]) !!}
                                <label for="txtComplement" class="label-input">Complemento</label>
                                {!! Form::text('addresses[0][complement]', null, ['id' => 'txtComplement', 'placeholder' => 'Complemento', 'class' => 'number input-register two-fields float-right ' . ($errors->has('addresses.0.complement') ? 'error-field' : '')]) !!}
                            </li>
                            <li>
                                <label for="txtDistrict" class="label-input">Bairro *</label>
                                {!! Form::text('addresses[0][district]', null, ['id' => 'txtDistrict', 'placeholder' => 'Bairro *', 'class' => 'input-register full ' . ($errors->has('addresses.0.district') ? 'error-field' : '')]) !!}
                            </li>
                            <li>
                                <div class="select-standard half form-control-white {{ $errors->has('addresses.0.state') ? 'error-field' : '' }}">
                                    <select name="addresses[0][state]" id="selectState" class="form-control select2" style="width: 100%;" data-state data-target="#selectCity" data-value="{{ old('addresses.0.state') }}">
                                        <option value="">Estado</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->getId() }}" @if($state->getId() == old('addresses.0.state')) selected @endif>
                                                {{ $state->getUf() }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </li>

                            <li>
                                <div class="select-standard full form-control-white {{ $errors->has('addresses.0.city') ? 'error-field' : '' }}">
                                    <select name="addresses[0][city]" id="selectCity" class="form-control select2" style="width: 100%;" data-city data-value="{{ old('addresses.0.city') }}">
                                        <option value="">Cidade</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <label for="addressLandmark" class="label-input">Referência para entrega</label>
                                {!! Form::text('addresses[0][landmark]', null, ['id' => 'addressLandmark', 'placeholder' => 'Referência para entrega', 'class' => 'input-register full ' . ($errors->has('addresses.0.landmark') ? 'error-field' : '')]) !!}
                            </li>
                        </ul>

                    </div>

                </div>

                <div class="col-register3 template1">
                    <div class="user-phones">
                        <h2 class="title-form">Contatos *</h2>
                        <ul class="list-form-register">
                            <li>
                                <label for="txtCellPhone" class="label-input">Telefone celular *</label>
                                {!! Form::tel('cellPhone', null, ['id' => 'txtCellPhone', 'placeholder' => 'Telefone celular *', 'class' => 'cel input-register full ' . ($errors->has('cellPhone') ? 'error-field' : ''), 'cel-phone-mask']) !!}
                            </li>
                            <li>
                                <label for="txtPhone" class="label-input">Telefone fixo</label>
                                {!! Form::tel('phone', null, ['id' => 'txtPhone', 'placeholder' => 'Telefone fixo', 'class' => 'cel input-register full ' . ($errors->has('phone') ? 'error-field' : ''), 'phone-mask']) !!}
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="wrap-content-bt">
                    <div class="content-bt-big">
                        <button type="submit" class="bt-default-full bt-color">Criar conta <span class="arrow-link">></span></button>
                    </div>
                </div>

            {!! Form::close() !!}

        </article>

    </div>

    <div class="border-footer">
        @include('website::layouts.footer')
    </div>

@stop
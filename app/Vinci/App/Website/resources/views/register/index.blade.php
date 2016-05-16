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

    <div class="row">

        <header class="header-content-internal">

            <div class="container-total-products">
                <span class="title-internal-15">Para criar a sua conta basta preencher os dados abaixo</span>
                <p>* Campos obrigatórios</p>
                @if($errors->has())
                    <p>{{ $errors->first() }}</p>
                @endif
            </div>

        </header>

        <article class="wrap-content-register">

            {!! Form::open(['route' => 'register.store', 'method' => 'post']) !!}

                <header class="header-content-internal">
                    <ul class="list-type-buyer">
                        <li>
                            <label for="physical-person">Pessoa Física</label>
                            <input type="radio" name="type-buyer" value="1" class="physical-person" id="physical-person"
                                   checked>
                        </li>
                        <li>
                            <label for="legal-person">Pessoa Jurídica</label>
                            <input type="radio" name="type-buyer" value="2" class="legal-person" id="legal-person">
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
                                <label for="password" class="label-input">Senha *</label>
                                {!! Form::password('password', ['id' => 'password', 'placeholder' => 'Senha *', 'class' => 'email input-register half ' . ($errors->has('password') ? 'error-field' : '')]) !!}
                            </li>
                            <li>
                                <label for="passwordConfirmation" class="label-input">Confirmar senha *</label>
                                {!! Form::password('password_confirmation', ['id' => 'passwordConfirmation', 'placeholder' => 'Confirmar senha *', 'class' => 'email input-register half ' . ($errors->has('password') ? 'error-field' : '')]) !!}
                            </li>
                        </ul>

                        <div class="" id="person">
                            <h2 class="title-form">Dados Pessoais *</h2>
                            <ul class="list-form-register">
                                <li>
                                    <label for="name" class="label-input">Nome completo *</label>
                                    {!! Form::text('name', null, ['id' => 'name', 'placeholder' => 'Nome completo *', 'class' => 'email input-register full ' . ($errors->has('name') ? 'error-field' : '')]) !!}
                                </li>
                                <li>
                                    <label for="cpf" class="label-input">CPF *</label>
                                    <input class="cpf input-register full" type="text" placeholder="CPF *" cpf id="cpf">
                                </li>
                                <li>
                                    <label for="rg" class="label-input">RG</label>
                                    <input class="rg input-register full" type="text" placeholder="RG" id="rg">
                                </li>
                                <li>
                                    <label for="orgao-emissor" class="label-input">Orgão Emissor *</label>
                                    <input class="orgao-emissor input-register half" type="text"
                                           placeholder="Orgão Emissor *" id="orgao-emissor">
                                </li>
                                <li>
                                    <div class="select-standard form-control-white">
                                        <select class="" name="" id="">
                                            <option value="">Sexo *</option>
                                            <option value="">Masculino</option>
                                            <option value="">Feminino</option>
                                        </select>
                                    </div>
                                </li>
                                <li>
                                    <label for="birth-date" class="label-input">Data de Nascimento *</label>
                                    <input class="birth-date input-register seventy" type="text"
                                           placeholder="Data de Nascimento *" date id="birth-date">
                                </li>
                            </ul>
                        </div>

                        <div class="" id="company">
                            <h2 class="title-form">Dados Empresa *</h2>
                            <ul class="list-form-register">
                                <li>
                                    <label for="name-company" class="label-input">Nome da empresa *</label>
                                    <input class="name-complete-company input-register full" type="text"
                                           placeholder="Nome da empresa *" id="name-company">
                                </li>
                                <li>
                                    <label for="responsavel" class="label-input">Responsável</label>
                                    <input class="input-register full" type="text" placeholder="Responsável"
                                           id="responsavel">
                                </li>
                                <li>
                                    <label for="cnpj" class="label-input">CNPJ *</label>
                                    <input class="cnpj input-register full" type="text" placeholder="CNPJ *" cnpj
                                           id="cnpj">
                                </li>
                                <li>
                                    <label for="ie" class="label-input">IE *</label>
                                    <input class="ie input-register full" type="text" placeholder="IE *" id="ie">
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>

                <div class="col-register2 template1">

                    <div class="user-address">
                        <h2 class="title-form">Endereço de Entrega *</h2>
                        <ul class="list-form-register">
                            <li>
                                <ul class="list-type-radio-3cols">
                                    <li>
                                        <label for="residencial">Residencial</label>
                                        <input type="radio" name="delivery-addres" value="1" class="physical-person"
                                               id="residencial" checked>
                                    </li>
                                    <li>
                                        <label for="comercial">Comercial</label>
                                        <input type="radio" name="delivery-addres" value="2" class="legal-person"
                                               id="comercial">
                                    </li>

                                    <li>
                                        <label for="outros">Outros</label>
                                        <input type="radio" name="delivery-addres" value="3" class="legal-person"
                                               id="outros">
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <label for="type-addres" class="label-input">Tipo de endereço (Ex: casa, trabalho)
                                    *</label>
                                <input class="type-addres input-register full" type="text"
                                       placeholder="Tipo de endereço (Ex: casa, trabalho) *" id="type-addres">
                            </li>
                            <li>
                                <label for="cep" class="label-input">CEP *</label>


                                <input type="text" name="addresses[0][postal_code]" class="cep input-register half" placeholder="CEP *"
                                       value="{{ old('addresses.0.postal_code') }}"
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
                                    <select class="" name="" id="">
                                        <option value="">Rua</option>
                                        <option value="">Avenida</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <label for="address" class="label-input">Endereço *</label>
                                <input class="input-register full" type="text" placeholder="Endereço *" id="address">
                            </li>
                            <li>
                                <label for="num" class="label-input">n° *</label>
                                <input class="number input-register two-fields" type="text" placeholder="n° *" id="num">
                                <label for="complement" class="label-input">Complemento</label>
                                <input class="number input-register float-right two-fields" type="text"
                                       placeholder="Complemento" id="complement">
                            </li>
                            <li>
                                <label for="bairro" class="label-input">Bairro *</label>
                                <input class="input-register full" type="text" placeholder="Bairro *" id="bairro">
                            </li>
                            <li>
                                <div class="select-standard half form-control-white">
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
                                <div class="select-standard full form-control-white">
                                    <select name="addresses[0][city]" id="selectCity" class="form-control select2" style="width: 100%;" data-city data-value="{{ old('addresses.0.city') }}">
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

                </div>

                <div class="col-register3 template1">
                    <div class="user-phones">
                        <h2 class="title-form">Contatos *</h2>
                        <ul class="list-form-register">
                            <li>
                                <label for="phone1" class="label-input">Telefone celular *</label>
                                <input class="cel input-register full" type="tel" placeholder="Telefone celular *"
                                       phone-mask id="phone1">
                            </li>
                            <li>
                                <label for="phone2" class="label-input">Telefone fixo</label>
                                <input class="phone2 input-register full" type="tel" placeholder="Telefone fixo"
                                       phone-mask id="phone2">
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="wrap-content-bt">
                    <div class="content-bt-big">
                        <button type="submit" class="bt-default-full bt-color">Criar conta <span class="arrow-link">></span></button>
                    </div>
                </div>
            </form>

        </article>

    </div>

    <div class="border-footer">
        @include('website::layouts.footer')
    </div>

@stop
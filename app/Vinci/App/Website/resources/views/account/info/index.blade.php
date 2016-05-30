@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('account.edit') }}"><span>Dados da conta</span></a>
    </li>
@endsection

@section('account.content')

    <article class="wrap-content-register">
        
        {!! Form::model($customer, ['route' => ['account.update', $customer->getId()], 'method' => 'PUT']) !!}

            <div class="col-register1 template4">

                <div class="user-data">
                    <h2 class="title-form">Dados de acesso *</h2>
                    <ul class="list-form-register">
                        <li>
                            <label for="txtEmail" class="label-input">E-mail *</label>
                            {{ Form::email('email', null, ['placeholder' => 'E-mail *', 'id' => 'txtEmail', 'class' => 'email input-register full']) }}
                        </li>
                        <li>
                            <label for="txtPassword" class="label-input">Senha *</label>
                            {{ Form::password('password', ['placeholder' => 'Senha *', 'id' => 'txtPassword', 'class' => 'senha input-register half']) }}
                        </li>
                        <li>
                            <label for="txtPasswordConfirmation" class="label-input">Confirmação da senha *</label>
                            {{ Form::password('password_confirmation', ['placeholder' => 'Confirmação da senha *', 'id' => 'txtPasswordConfirmation', 'class' => 'senha input-register half']) }}
                        </li>
                    </ul>

                </div>

            </div>

            <div class="col-register2 template4">

                <div class="user-address">
                    <div class="">
                        <h2 class="title-form">Dados Pessoais *</h2>
                        <ul class="list-form-register">
                            <li>
                                <label for="txtName" class="label-input">Nome completo *</label>
                                {{ Form::text('name', null, ['id' => 'txtName', 'class' => 'name-complete input-register full', 'placeholder' => 'Nome completo *']) }}
                            </li>
                            <li>
                                <label for="txtCpf" class="label-input">CPF *</label>
                                {{ Form::text('cpf', null, ['id' => 'txtCpf', 'class' => 'name-complete input-register full', 'placeholder' => 'CPF *', 'cpf']) }}
                            </li>
                            <li>
                                <label for="txtRg" class="label-input">RG</label>
                                {{ Form::text('rg', null, ['id' => 'txtRg', 'class' => 'name-complete input-register full', 'placeholder' => 'RG']) }}
                            </li>
                            <li>
                                <label for="txtIssuingBody" class="label-input">Orgão Emissor *</label>
                                {{ Form::text('issuingBody', null, ['id' => 'txtIssuingBody', 'class' => 'name-complete input-register full', 'placeholder' => 'Orgão Emissor']) }}
                            </li>
                            <li>
                                <div class="select-standard form-control-white">
                                    {!! Form::select('gender', ['' => 'Sexo *', \Vinci\Domain\Common\Gender::MALE => 'Masculino', \Vinci\Domain\Common\Gender::FEMALE => 'Feminino'], null, ['id' => 'selectGender']) !!}
                                </div>
                            </li>
                            <li>
                                <label for="birth-date" class="label-input">Data de Nascimento *</label>
                                {!! Form::text('birthday', $customer->getBirthday()->format('d/m/Y'), ['id' => 'txtBirthday', 'placeholder' => 'Data de Nascimento *', 'class' => 'birth-date input-register seventy ' . ($errors->has('birthday') ? 'error-field' : ''), 'date']) !!}
                            </li>
                        </ul>
                    </div>

                    <div class="" style="display: none;">
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
                                <label for="ie" class="label-input">IE</label>
                                <input class="ie input-register full" type="text" placeholder="IE" id="ie">
                            </li>

                        </ul>
                    </div>

                </div>

            </div>

            <div class="col-register3 template4">

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
                    <button type="submit" class="bt-default-full template11 bt-middle">Atualizar dados <span class="arrow-link">></span></button>
                </div>
            </div>
        {!! Form::close() !!}

    </article>

@stop
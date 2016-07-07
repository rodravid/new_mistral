@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('account.edit') }}"><span>Dados da conta</span></a>
    </li>
@endsection

@section('account.content')

    <article class="wrap-content-register">

        @if($errors->has())

            {{ $errors->first() }}

        @endif
        
        {!! Form::model($customer, ['route' => ['account.update', $customer->getId()], 'method' => 'PUT']) !!}
            <input type="hidden" name="id" value="{{ $customer->getId() }}">
            <input type="hidden" name="customerType" value="{{ $customer->getCustomerType() }}">

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

                    @if ($customer->isIndividual())
                        <div class="">
                            <h2 class="title-form">Dados Pessoais *</h2>
                            <ul class="list-form-register">
                                <li>
                                    <label for="txtName" class="label-input">Nome completo *</label>
                                    {{ Form::text('name', null, ['id' => 'txtName', 'class' => 'name-complete input-register full ' . ($errors->has('name') ? 'error-field' : ''), 'placeholder' => 'Nome completo *']) }}
                                </li>
                                <li>
                                    <label for="txtCpf" class="label-input">CPF *</label>
                                    {{ Form::text('cpf', null, ['id' => 'txtCpf', 'class' => 'name-complete input-register full ' . ($errors->has('cpf') ? 'error-field' : ''), 'placeholder' => 'CPF *', 'cpf']) }}
                                </li>
                                <li>
                                    <label for="txtRg" class="label-input">RG</label>
                                    {{ Form::text('rg', null, ['id' => 'txtRg', 'class' => 'name-complete input-register full ' . ($errors->has('rg') ? 'error-field' : ''), 'placeholder' => 'RG']) }}
                                </li>
                                <li>
                                    <label for="txtIssuingBody" class="label-input">Orgão Emissor *</label>
                                    {{ Form::text('issuingBody', null, ['id' => 'txtIssuingBody', 'class' => 'name-complete input-register full ' . ($errors->has('issuingBody') ? 'error-field' : ''), 'placeholder' => 'Orgão Emissor']) }}
                                </li>
                                <li>
                                    <div class="select-standard form-control-white {{ $errors->has('gender') ? 'error-field' : '' }}">
                                        {!! Form::select('gender', ['' => 'Sexo *', \Vinci\Domain\Common\Gender::MALE => 'Masculino', \Vinci\Domain\Common\Gender::FEMALE => 'Feminino'], null, ['id' => 'selectGender']) !!}
                                    </div>
                                </li>
                                <li>
                                    <label for="birth-date" class="label-input">Data de Nascimento *</label>
                                    {!! Form::text('birthday', $customer->getBirthday()->format('d/m/Y'), ['id' => 'txtBirthday', 'placeholder' => 'Data de Nascimento *', 'class' => 'birth-date input-register seventy ' . ($errors->has('birthday') ? 'error-field' : ''), 'date']) !!}
                                </li>
                            </ul>
                        </div>

                    @elseif($customer->isCompany())
                        <div>
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
                    @endif

                </div>

            </div>

            <div class="col-register3 template4">

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
                    <button type="submit" class="bt-default-full template11 bt-middle">Atualizar dados <span class="arrow-link">></span></button>
                </div>
            </div>
        {!! Form::close() !!}

    </article>

@stop
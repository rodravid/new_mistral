@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('account.edit') }}"><span>Dados da conta</span></a>
    </li>
@endsection

@section('account.content')

    <article class="wrap-content-register">

        <form action="">

            <div class="col-register1 template4">

                <div class="user-data">
                    <h2 class="title-form">Dados de acesso *</h2>
                    <ul class="list-form-register">
                        <li>
                            <label for="email" class="label-input">E-mail</label>
                            <input class="email input-register full" type="email" placeholder="E-mail *" id="email">
                        </li>
                        <li>
                            <label for="password" class="label-input">Senha</label>
                            <input class="senha input-register half" type="password" placeholder="Senha *"
                                   id="password">
                        </li>
                        <li>
                            <label for="password2" class="label-input">Confirmar senha</label>
                            <input class="senha input-register half" type="password" placeholder="Confirmar senha *"
                                   id="password2">
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
                                <label for="name-complete" class="label-input">Nome completo *</label>
                                <input class="name-complete input-register full" type="text"
                                       placeholder="Nome completo *" id="name-complete">
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
                    <a class="bt-default-full template11 bt-middle" href="#">Atualizar dados <span class="arrow-link">></span></a>
                </div>
            </div>
        </form>

    </article>

@stop
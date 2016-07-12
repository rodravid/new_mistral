@extends('website::layouts.emails.templates.default')

@section('body')

    @include('website::layouts.emails.templates.partials.salutation')

    Agradecemos a atualização de seus dados no site da Vinci.<br/><br/>

    Por favor, confira abaixo as informações que agora constam em seu cadastro:<br /><br />

    <b>Dados Pessoais</b><br>
    <b>Nome: </b>{{ $customer->name }}<br>
    <b>CPF/CNPJ: </b>{{ $customer->document }}<br>
    @if(! empty($customer->rg))
        <b>RG: </b>{{ $customer->rg }}<br>
    @endif
    @if ($customer->isIndividual())
        <b>Sexo: </b>{{ $customer->gender }}<br>
        <b>Data de Nascimento: </b>{{ $customer->birthday }}<br>
    @endif
    <br>

    <b>Endereço principal</b><br>
    <b>Tipo: </b> {!! $customer->getMainAddress()->getType()->getTitle() !!}<br>
    <b>Endereço: </b> {!! $customer->full_address_html !!}<br>

    <b>Contatos</b><br>
    @if(! empty($customer->phone))
        <b>Telefone: </b>{{ $customer->phone }} <br>
    @endif

    @if(! empty($customer->cellPhone))
        <b>Telefone Celular: </b>{{ $customer->cellPhone }} <br>
    @endif

    @if(! empty($customer->commercialPhone))
        <b>Telefone Comercial: </b>{{ $customer->commercialPhone }} <br>
    @endif

    <b>E-mail: </b>{{ $customer->email }}<br>

    @include('website::layouts.emails.templates.partials.additional_message')

@endsection
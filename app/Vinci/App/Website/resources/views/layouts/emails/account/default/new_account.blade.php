@extends('website::layouts.emails.templates.default')

@section('body')


		Prezado(a) Sr.(a) <b><span style="color: #11b6f0 !important;">{{ $customer->name }}</span>,</b><br/><br/>

		Obrigado por preferir a VINCI.<br/><br/>

		Por favor, confira abaixo as informações que agora constam no cadastro:<br /><br />

		<b>Nome: </b>{{ $customer->name }}<br>


		<b>CPF/CNPJ: </b>{{ $customer->document }}<br>

		@if(! empty($customer->rg))
			<b>RG: </b>{{ $customer->rg }}<br>
		@endif
		<br>

		<b>Endereço principal</b><br>

		<b>Tipo: </b> {!! $customer->getMainAddress()->getType()->getTitle() !!}<br>

		<b>Endereço: </b> {!! $customer->full_address_html !!}<br>

		@if ($customer->isIndividual())
			<b>Data de Nascimento: </b>{{ $customer->birthday }}<br>

			<b>Sexo: </b>{{ $customer->gender }}<br>
		@endif

		@if(! empty($customer->Phone))
			<b>Telefone: </b>{{ $customer->Phone }} <br>
		@endif

		@if(! empty($customer->cellPhone))
			<b>Celular: </b>{{ $customer->cellPhone }} <br>
		@endif

		<b>E-mail: </b>{{ $customer->email }}<br>

		@include('website::layouts.emails.templates.partials.additional_message')

@endsection
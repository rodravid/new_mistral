@extends('website::layouts.emails.templates.default')

@section('body')


		Prezado(a) Sr.(a) <b><span style="color: #11b6f0 !important;">{{ $customer->name }}</span>,</b><br/><br/>

		Obrigado por preferir a VINCI.<br/><br/>

		Confira abaixo as informações que agora constam no cadastro:<br /><br />

		<b>Nome: </b>{{ $customer->name }}<br>

		<b>CPF: </b>{{ $customer->cpf }}<br>

		@if(! empty($customer->rg))
		<b>RG: </b>{{ $customer->rg }}<br>
		@endif
		<br>

		<b>Endereço: </b> {!! $customer->full_address_html !!}    <br>

		<b>Data de Nascimento: </b>{{ $customer->birthday }}<br>

		<b>Sexo: </b>{{ $customer->gender }}<br>

		@if(! empty($customer->Phone))
		<b>Telefone: </b>{{ $customer->Phone }} <br>
		@endif

		@if(! empty($customer->cellPhone))
		<b>Celular: </b>{{ $customer->cellPhone }} <br>
		@endif

		<b>E-mail: </b>{{ $customer->email }}<br>



@endsection
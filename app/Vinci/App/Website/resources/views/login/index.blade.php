@extends('website::layouts.master')


@section('content')
<div class="header-internal template1-bg">
	@include('website::layouts.menu')
	<div class="row">

		<h1 class="internal-subtitle">Login</h1>

		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>

			<li class="breadcrumb-item">
				<span>Login</span>
			</li>
		</ul>

	</div>
</div>

<div class="row">


	<article class="wrap-content-register">

		<div class="pg-log">
			<div class="">
				<ul class="list-form-register">
					<li>
						<!-- <label for="">E-mail</label> -->
						<input class="email input-register full" type="text" placeholder="E-mail">
					</li>
					<li>
						<input class="senha input-register full" type="password" placeholder="Senha">
						<a class="forgot-pass call-recovery" href="javascript:void(0);">Esqueceu a senha ?</a>
					</li>

				</ul>
				<a class="bt-default-full bt-middle template1" href="#">Entrar <span class="arrow-link">></span></a>
			</div>
			<div class="footer-modal">
				<div class="center-content-bt">
					<a href="/cadastro">
						<span class="txt-register">Se você ainda não possui <br> conta, cadastre-se aqui</span>
						<span class="bt-arrow">></span>
					</a>
				</div>
			</div>
			<a href="javascript:void(0)" class="close">X</a>
		</div>


	</article>

</div>

@include('website::layouts.footer')



@stop
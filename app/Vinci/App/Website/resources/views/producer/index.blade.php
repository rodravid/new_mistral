@extends('website::layouts.master')

@section('title', 'Vinci - ' . $producer->seo()->title())

@section('content')
<div class="header-internal template3-bg bg-color-category" style="background: url({{ asset_web('images/bg-produtor.jpg') }}) no-repeat top right;">
	@include('website::layouts.menu')
	<div class="row">
		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>
            <li class="breadcrumb-item">
                <a class="breadcrumb-link" href="/c/produtores"><span>Vinho por produtor</span></a> >
            </li>
			<li class="breadcrumb-item">
				<span>{{ $producer->name }}</span>
			</li>
		</ul>

		<h1 class="internal-subtitle-category">{{ $producer->name }}</h1>
		<div class="container-leia-mais">
			<p class="category-description">
				{!! $producer->description !!}
			</p>
		</div>
	</div>
</div>

@include('website::search.box')

<div class="bg-layer-filtro"></div>

@include('website::layouts.footer')

@stop
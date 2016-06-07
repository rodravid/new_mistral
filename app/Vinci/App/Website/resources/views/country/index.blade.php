@extends('website::layouts.master')

@section('title', 'Vinci - ' . $country->seo()->title())

@section('content')
<div class="header-internal template1-bg bg-color-category" style="background: url({{ asset_web('images/bg-pais.jpg') }}) no-repeat top right;">
	@include('website::layouts.menu')
	<div class="row">
		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>
            <li class="breadcrumb-item">
                <a class="breadcrumb-link" href="/c/paises"><span>Vinho por país</span></a> >
            </li>
			<li class="breadcrumb-item">
				<span>{{ $country->name }}</span>
			</li>
		</ul>

		<h1 class="internal-subtitle-category">{{ $country->name }}</h1>
		<div class="container-leia-mais">
			<p class="category-description">
                {{ $country->description }}
			</p>
		</div>
	</div>
</div>

@include('website::search.box')

<div class="bg-layer-filtro"></div>

@include('website::layouts.footer')

@stop
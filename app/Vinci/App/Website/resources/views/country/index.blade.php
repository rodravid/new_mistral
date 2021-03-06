@extends('website::layouts.master')

@section('title', $country->seo()->title())
@section('description', $country->seo()->description())

@section('content')
<div class="header-internal template1-bg bg-color-category" style="background: url({{ asset_web('images/bg-pais.png') }}) no-repeat top right;">
	@include('website::layouts.menu')
	<div class="row">
		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>
            <li class="breadcrumb-item">
                <a class="breadcrumb-link" href="{{ route('category.countries.list') }}"><span>Vinho por país</span></a> >
            </li>
			<li class="breadcrumb-item">
				<span>{{ $country->name }}</span>
			</li>
		</ul>

		<h1 class="internal-subtitle-category">{{ $country->name }}</h1>
		<div class="container-leia-mais">
			<p class="category-description">
                {!! $country->description !!}
			</p>
		</div>
	</div>
</div>

@include('website::search.box', ['template' => 'template1'])

<div class="bg-layer-filtro"></div>

@include('website::layouts.footer')

@stop
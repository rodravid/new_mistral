@extends('website::layouts.master')

@section('title', $grape->seo()->title())
@section('description', $grape->seo()->description())

@section('content')
<div class="header-internal template5-bg bg-color-category" style="background: url({{ asset_web('images/bg-tipo-uva.jpg') }}) no-repeat top right;">
	@include('website::layouts.menu')
	<div class="row">
		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>
            <li class="breadcrumb-item">
                <a class="breadcrumb-link" href="/c/tipos-de-uvas"><span>Vinhos por tipo de uva</span></a> >
            </li>
			<li class="breadcrumb-item">
				<span>{{ $grape->name }}</span>
			</li>
		</ul>

		<h1 class="internal-subtitle-category">{{ $grape->name }}</h1>
		<div class="container-leia-mais">
			<p class="category-description">
                {!! $grape->description !!}
			</p>
		</div>
	</div>
</div>

@include('website::search.box', ['template' => 'template5'])

<div class="bg-layer-filtro"></div>

@include('website::layouts.footer')

@stop
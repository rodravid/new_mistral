@extends('website::layouts.master')

@section('title', 'Vinci - ' . $showcase->title)

@section('content')
<div class="header-internal {{ $showcase->template_css }}-bg bg-color-category" style="background: url({{ $showcase->banner_image_url }}) no-repeat top right;">
	@include('website::layouts.menu')
	<div class="row">
		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>
            <li class="breadcrumb-item">
                <a class="breadcrumb-link" href="/c/paises"><span>Categoria</span></a> >
            </li>
			<li class="breadcrumb-item">
				<span>{{ $showcase->title }}</span>
			</li>
		</ul>

		<h1 class="internal-subtitle-category">{{ $showcase->title }}</h1>
		<div class="container-leia-mais">
			<p class="category-description">
                {!! $showcase->description !!}
			</p>
		</div>
	</div>
</div>

@include('website::search.box', ['template' => $showcase->template_css])

<div class="bg-layer-filtro"></div>

@include('website::layouts.footer')

@stop
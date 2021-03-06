@extends('website::layouts.master')

@section('title', $region->seo()->title())
@section('description', $region->seo()->description())

@section('content')
<div class="header-internal template2-bg bg-color-category" style="background: url({{ asset_web('images/bg-regiao.jpg') }}) no-repeat top right;">
	@include('website::layouts.menu')
	<div class="row">
		<ul class="breadcrumb">
			<li class="breadcrumb-item">
				<a class="breadcrumb-link" href="/"><span>Início</span></a> >
			</li>
            <li class="breadcrumb-item">
                <a class="breadcrumb-link" href="{{ route('category.regions.list') }}"><span>Vinhos por região</span></a> >
            </li>
			<li class="breadcrumb-item">
				<span>{{ $region->name }}</span>
			</li>
		</ul>

		<h1 class="internal-subtitle-category">{{ $region->name }}</h1>
		<div class="container-leia-mais">
			<p class="category-description">
				{!! $region->description !!}
			</p>
		</div>
	</div>
</div>

@include('website::search.box', ['template' => 'template2'])

<div class="bg-layer-filtro"></div>

@include('website::layouts.footer')

@endsection
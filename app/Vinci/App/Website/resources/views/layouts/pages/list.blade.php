@extends('website::layouts.master')

@section('title', $metaTitle)

@section('content')
    <div class="header-internal {{ $template }}-bg bg-color-category" style="background: url({{ asset_web('images/' . $imageTitle) }}) no-repeat top right;">
        @include('website::layouts.menu')
        <div class="row">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="/"><span>Início</span></a> >
                </li>
                <li class="breadcrumb-item">
                    <span>{{ $pageTitle }}</span>
                </li>
            </ul>

            <h1 class="internal-subtitle-category">Vinhos por {{ $pageTitle }}</h1>
            <div class="container-leia-mais">
                <p class="category-description">
                    {{ $pageDescription }}
                </p>
            </div>
        </div>
    </div>

    <div class="row {{ $template }}">
        <ul class="alphabet-list">
            {!! makeAlphabet($resources->getAvailableLetters()) !!}
        </ul>

        @foreach($resources->groupByLetters()->chunk(4) as $group)
            <div class="line-category">

                @foreach($group as $resourceGroup)
                    <ul class="line-category-content" id="{{ $resourceGroup->letter }}">

                        <h3 class="title-line-category">{{ $resourceGroup->letter }}</h3>

                        @foreach($resourceGroup->items as $item)
                            <li class="item-line-category">
                                <a class="link-line-category" href="{{ route('category.' . $resourceType . '.show', [$item->getSlug()]) }}">{{ $item->getName() }}</a>
                            </li>
                        @endforeach

                    </ul>
                @endforeach

            </div>
        @endforeach

    </div>

    @include('website::layouts.footer')

@stop
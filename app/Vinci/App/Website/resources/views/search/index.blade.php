@extends('website::layouts.master')

@section('content')
    <div class="header-internal template1-bg">
        @include('website::layouts.menu')
        <div class="row">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="/"><span>Início</span></a> >
                </li>
                <li class="breadcrumb-item">
                    <span>Resultado de busca</span> >
                </li>
                <li class="breadcrumb-item">
                    <span>{{ $result->getTerm() }}</span>
                </li>
            </ul>
            <span class="internal-subtitle">Resultado de busca</span>

            @if(! empty($result->getTerm()))
                <h1 class="search-item">{{ $result->getTerm() }}</h1>
            @endif
        </div>
    </div>

    @include('website::search.box')

    <div class="bg-layer-filtro"></div>

    @include('website::layouts.footer')

@stop
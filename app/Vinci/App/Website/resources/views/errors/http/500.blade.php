@extends('website::layouts.master')

@section('content')

    <div class="header-internal template1-bg">
        @include('website::layouts.menu')

        <div class="row">
            <h1 class="internal-subtitle-category">Erro 500</h1>
        </div>

    </div>

    <div class="row">

        <h2 class="mbottom20"> Desculpe. No momento não é possível completar sua solicitação.</h2>

        <p class="mbottom20"> Se você está procurando os melhores vinhos, use um dos links abaixo:</p>

        <ul>
            <li class="mbottom10"><a class="link-light" href="/">Home</a></li>
            <li class="mbottom10"><a class="link-light" href="/c/pais/">Vinhos por País</a></li>
            <li class="mbottom10"><a class="link-light" href="/c/regiao/">Vinhos por Região</a></li>
            <li class="mbottom10"><a class="link-light" href="/c/produtor/">Vinhos por Produtor</a></li>
            <li class="mbottom10"><a class="link-light" href="/c/tipo-de-vinho/">Vinhos por tipo de Vinhos</a></li>
            <li class="mbottom10"><a class="link-light" href="/c/tipo-de-uva/">Vinhos por tipo de Uvas</a></li>
        </ul>

    </div>
    <div class="border-footer">
        @include('website::layouts.footer')
    </div>
@endsection
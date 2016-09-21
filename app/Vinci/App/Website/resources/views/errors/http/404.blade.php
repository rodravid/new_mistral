@extends('website::layouts.master')

@section('content')

    <div class="header-internal template3-bg bg-color-category">
        @include('website::layouts.menu')
        <div class="row">

            404

            Desculpe. Ocorreu um erro e o conteúdo que você está procurando não foi encontrado. Isso pode ter acontecido por dois motivos:

            • O endereço não foi digitado corretamente.
            • A página não existe mais ou mudou de endereço.
            Se você está procurando os melhores vinhos, use um dos links abaixo:

            Home
            Vinhos por País
            Vinhos por Região
            Vinhos por Produtor
            Vinhos por tipo de Vinhos
            Vinhos por tipo de Uvas

        </div>
    </div>

    @include('website::layouts.footer')
@endsection
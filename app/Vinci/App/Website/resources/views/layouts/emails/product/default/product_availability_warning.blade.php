@extends('website::layouts.emails.order.default.layouts.template')

@section('body')

    @include('website::layouts.emails.order.default.layouts.partials.salutation')

    Gostaríamos de informá-lo(a) que o produto {{ $product->title }} já está disponível novamente em nosso site.

    Importante: este é apenas um aviso automático e não garante a reserva do produto.

    Para comprá-lo clique em: <a href="{{ url($product->getWebPath()) }}">{{ $product->title }}</a>.

    @include('website::layouts.emails.order.default.layouts.partials.additional_message')

@endsection

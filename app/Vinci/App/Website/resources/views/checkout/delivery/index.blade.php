@extends('website::layouts.master')

@section('content')
    <div class="header-internal header-checkout template1-bg">

        <div class="row">

            <div class="wrap-content-bt mbottom20 mtop20">
                <span class="logo">
                    <a class="logo-vinci sprite-icon" href="/" title="Vinci - Loucos por vinho">Vinci - Loucos por vinho</a>
                </span>
            </div>

            <h1 class="internal-subtitle">Meu Carrinho</h1>

            <nav class="nav-status float-right">
                <ul class="list-status">
                    <li class="current-status">
                        <span>Entrega</span>
                        <img class="cup-status" src="{{ asset_web('images/taca.png') }}" alt="">
                    </li>
                    <li class="show-desktop">
                        <span>Pagamento</span>

                    </li>
                    <li class="show-desktop">
                        <span>Confirmação</span>
                    </li>

                </ul>
            </nav>

        </div>
    </div>

    <div class="row">

        <div class="wrap-content-bt mbottom20">
            <span class="title-internal-15 float-left">Escolha o endereço de entrega</span>
            <div class="content-bt-middle hide-mobile">
                <a class="bt-default-full bt-color call-adress" href="javascript:void(0);">Novo endereço <span
                            class="arrow-link">&gt;</span></a>
            </div>
        </div>

        <section class="adress-delivery">

            {!! Form::open(['route' => 'checkout.payment.index', 'method' => 'GET']) !!}

            @foreach($addresses as $address)

                <div class="adress">
                    <a href="javascript:void(0);" class="bt-edit call-adress" data-address-id="{{ $address->id }}" title="Editar Endereço"> > </a>
                    <div class="content-adress mbottom20">
                        <h4 class="uppercase mbottom20">{{ $address->nickname }}</h4>
                        {!! $address->address_html !!}
                    </div>
                    <button type="submit" class="bt-default-full bt-color mtop20" name="address_id" value="{{ $address->id }}">Usar esse endereço <span class="arrow-link">&gt;</span></button>
                </div>

            @endforeach

            {!! Form::close() !!}

            <div class="wrap-content-bt mbottom20 show-mobile">
                <div class="content-bt-middle">
                    <a class="bt-default-full bt-color call-adress" href="#">Novo endereço <span class="arrow-link">&gt;</span></a>
                </div>
            </div>

        </section>
    </div>

    @include('website::layouts.partials.checkoutfooter')

@stop
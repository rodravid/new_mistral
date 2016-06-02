@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('account.addresses.index') }}"><span>Endereços</span></a>
    </li>
@endsection

@section('account.content')

    <div class="wrap-content-bt mbottom20">
        <span class="title-internal-15 float-left">Lista de endereços cadastrados</span>
        <div class="content-bt-middle mtop-ajust">
            <a class="bt-default-full template11 call-adress" href="javascript:void(0);">Novo endereço <span class="arrow-link">&gt;</span></a>
        </div>
    </div>

    <section class="adress-delivery adress-user">

        @forelse($addresses as $address)

            <div class="adress template4">
                <div class="content-adress mbottom20">
                    <h4 class="uppercase mbottom20">{{ $address->nickname }}</h4>
                    {!! $address->address_html !!}
                </div>
                <a class="bt-default-full template11 mtop20 call-adress" data-address-id="{{ $address->getId() }}" href="">Atualizar endereço <span class="arrow-link">&gt;</span></a>
            </div>

        @empty

            <h2>Nenhum endereço cadastrado.</h2>
        @endforelse

    </section>

@endsection
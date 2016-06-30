@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('account.orders.index') }}"><span>Meus pedidos</span> </a> >
    </li>
    <li class="breadcrumb-item">
        <span>{{ $order->number }}</span>
    </li>
@endsection

@section('account.content')

    <section class="wrap-payment template4">

    

    <div class="print mbottom20">
        <img src="{{ asset_web('images/logo-impressao.jpg') }}" alt="">
    </div>

        <div class="wrap-content-bt mbottom20 show-mobile no-print">
            <div class="content-bt-small ">
                <a class="bt-default-full template11 bt-middle" href="{{ route('account.orders.index') }}">Voltar <span class="arrow-link">></span></a>
            </div>
        </div>

        <div class="wrap-content-bt mbottom10 ">
            <p class="title-info-req">Número do pedido</p>
            <span class="num-request-cod">{{ $order->number }}</span>
            <div class="content-bt-small hide-mobile no-print">
                <a class="bt-default-full bt-middle template11" href="{{ route('account.orders.index') }}">Voltar <span class="arrow-link">></span></a>
            </div>
        </div>

        <article class="order section-payment">
            <div class="content-order float-left">
                <p class="txt-order">Data do pedido</p>
                <span class="title-txt-req">{{ $order->creation_date }}</span>
            </div>
            <div class="status-order float-right">
                <p class="txt-order">Status</p>
                <p class="title-internal-15">{{ $order->status }}</p>
            </div>
        </article>

        <div class="wrap-content-bt mbottom10 show-desktop hide-tablet no-print">
            <div class="content-bt-middle">
                <a class="bt-default-full template11 bt-middle" href="javascript:void(0);" onClick="window.print();">Imprimir pedido <span class="arrow-link">></span></a>
            </div>
        </div>

        <p class="title-internal mbottom20">Resumo do pedido</p>

        <article class="request section-confirmation">

            @foreach($order->getItems() as $item)

                <div class="row-request">
                    <div class="col-request">
                        <div class="name-product-request">
                            <h3 class="title-card-wine">
                                {{ $item->product->title }}
                                @if ($item->product->hasProducer())
                                    <span>{{ $item->product->producer->name }}</span>
                                @endif
                            </h3>
                        </div>

                        <div class="qtd-request">
                            {{ $item->quantity_units }}
                        </div>

                        <div class="price-request">
                            <span class="title-internal-15">{{ $item->total }}</span>
                        </div>
                    </div>
                </div>

            @endforeach

            <div class="row-request">
                <div class="info-request float-left">
                    <span class="title-internal-15">Frete</span>
                </div>
                <div class="price-final float-right">
                    <span class="title-internal-15">{{ $order->shipment->amount }}</span>
                </div>
            </div>

            <div class="row-request">
                <div class="info-request float-left">
                    <span class="title-internal-15">Total</span>
                </div>
                <div class="price-final float-right">
                    <span class="title-internal-15">{{ $order->total }}</span>
                </div>
            </div>

        </article>

        <div class="wrap-content-bt mbottom10 no-print">
            <div class="content-bt-middle ">
                <a class="bt-default-full template11 bt-middle" href="{{ route('account.orders.repeat', $order->number) }}">Repetir pedido <span class="arrow-link">></span></a>
            </div>
        </div>

        <p class="title-internal mbottom20">Endereço de Entrega</p>

        <article class="to-deliver section-payment">
            <div class="float-left">
                <span class="title-internal-15 uppercase">{{ $order->billingAddress->nickname }}</span>
                {!! $order->billingAddress->address_html !!}
            </div>
        </article>

        <p class="title-internal mbottom20">Forma de pagamento</p>

        <article class="purchase-data section-payment">
            <div class="content-img-card float-left">
                <img src="{{ $order->payment->method->icon_image_url }}" alt="">
            </div>
            <div class="info-card-payment">
                <p class="amount-paid">{{ $order->payment->installment_text }}</p>

                @if($order->payment->wasMadeWithCreditCard())
                    <p class="card-used">
                        {{ $order->payment->getCreditCard()->getHoldername() }}
                        <span>{{ $order->payment->getCreditCard()->getMaskedNumber() }}</span>
                    </p>
                @endif
            </div>
        </article>

        <div class="wrap-content-bt mbottom10 no-print">
            <div class="content-bt-small">
                <a class="bt-default-full template11 bt-middle" href="{{ route('account.orders.index') }}">Voltar <span class="arrow-link">></span></a>
            </div>
        </div>

    </section>

@stop
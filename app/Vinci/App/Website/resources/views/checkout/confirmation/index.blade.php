@extends('website::layouts.master')

@if ($googleTransactionProducts)

    @section('tagmanager')

        <script type="text/javascript">

            var transactionProducts = {!! $googleTransactionProducts !!};

        </script>

    @endsection

@endif

@section('content')
    <div class="header-internal header-checkout-confirmation template1-bg">
        @include('website::layouts.menu')
        <div class="row">

            <h1 class="internal-subtitle">Meu Carrinho</h1>

            <nav class="nav-status float-right">
                <ul class="list-status">

                    <li class="show-desktop">
                        <span>Entrega</span>
                    </li>
                    <li class="show-desktop">
                        <span>Pagamento</span>
                    </li>
                    <li class="current-status">
                        <span>Confirmação</span>
                        <img class="cup-status" src="{{ asset_web('images/taca.png') }}" alt="">
                    </li>

                </ul>
            </nav>

        </div>

    </div>

    <div class="row">

        <section class="wrap-payment">
        
    <div class="print mbottom20">
        <img src="{{ asset_web('images/logo-impressao.jpg') }}" alt="">
    </div>

            <div class="wrap-content-bt mbottom10">
                <span class="title-internal-confirmation uppercase float-left">Pedido concluído com sucesso!</span>
                <div class="content-bt-big hide-mobile no-print">
                    <a class="bt-default-full bt-middle bt-color" href="/">Continuar comprando <span class="arrow-link">&gt;</span></a>
                </div>
            </div>

            <p class="mbottom20">Agradecemos a sua compra. Você receberá um e-mail de confirmação do seu produto</p>

            <article class="order section-payment">
                <div class="content-order float-left">
                    <p class="txt-order">Número do pedido</p>
                    <span class="num-order">{{ $order->number }}</span>
                </div>
                <div class="status-order float-right">
                    <p class="txt-order">Status</p>
                    <p class="title-internal-15 mtop10">{{ $order->status }}</p>
                </div>
            </article>

            <div class="wrap-content-bt mbottom10 show-desktop hide-tablet no-print">
                <div class="content-bt-middle ">
                    <a class="bt-default-full template1 bt-middle" href="javascript:void(0);" onClick="window.print();">Imprimir pedido <span class="arrow-link">&gt;</span></a>
                </div>
            </div>

            <p class="title-internal-blue mbottom20">Resumo do pedido</p>

            <article class="request section-confirmation">

                @foreach($order->items as $item)

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

            <p class="title-internal-blue mbottom20">Endereço de Entrega</p>

            <article class="to-deliver section-payment">
                <div class="float-left">
                    <span class="title-internal-15 uppercase">{{ $order->shippingAddress->nickname }}</span>
                    {!! $order->shippingAddress->address_html !!}
                </div>

            </article>

            <p class="title-internal-blue mbottom20">Previsão de Entrega</p>

            <article class="to-deliver section-payment">
                <div class="float-left">
                    <p>{{ $order->shipment->deadline }}</p>
                </div>
            </article>

            <p class="title-internal-blue mbottom20">Forma de pagamento</p>

            <article class="purchase-data section-payment">
                    <div class="content-img-card float-left">
                        <img src="{{ $order->payment->method->icon_image_url }}" alt="">
                    </div>
                    <div class="info-card-payment">
                        <p class="amount-paid">{{ $order->payment->installment_text }}</p>
                        @if ($order->payment->wasMadeWithCreditCard())
                            <p class="card-used">
                                {{ $order->payment->credit_card->holdername }}
                                <span>{{ $order->payment->credit_card->masked_number }}</span>
                            </p>
                        @else
                            <p class="card-used">
                                Pago via depósito bancário
                            </p>
                        @endif
                    </div>
            </article>

            <div class="wrap-content-bt mbottom20 show-mobile no-print">
                <div class="content-bt-middle ">
                    <a class="bt-default-full bt-big bt-color" href="#">Continuar comprando <span class="arrow-link">&gt;</span></a>
                </div>
            </div>

        </section>

    </div>

    @include('website::layouts.footer')

@stop
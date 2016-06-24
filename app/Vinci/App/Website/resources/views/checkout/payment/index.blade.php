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
            <li class="show-desktop">
                <span>Entrega</span>
            </li>
            <li class="current-status">
                <span>Pagamento</span>
                <img class="cup-status" src="{{ asset_web('images/taca.png') }}" alt="">
            </li>
            <li class="show-desktop">
                <span>Confirmação</span>
            </li>
        </ul>
    </nav>

</div>
</div>

<div class="row">
    {!! Form::open(['route' => 'order.store', 'method' => 'post']) !!}
    <input type="hidden" name="shipping[address]" value="{{ $deliveryAddress->getId() }}">

    <section class="wrap-payment">

        <p class="title-internal-blue mbottom20">Resumo do pedido</p>

        <article class="request section-payment">

            <div class="cart-items-wrapper">
                @foreach($shoppingCart->getItems() as $item)
                <div class="row-request template1">
                    <div class="col-request">
                        <div class="name-product-request">
                            <h3 class="title-card-wine">
                                {{ $item->getTitle() }}
                                @if($item->hasProducer())
                                <span>{{ $item->getProducer()->getName() }}</span>
                                @endif
                            </h3>
                        </div>
                        <div class="qtd-request">{{ $item->quantity_units }}</div>
                        <div class="price-request">
                            <span class="title-internal-15">{{ $item->subtotal }}</span>
                        </div>
                    </div>
                    <div class="bt-request">
                        <a class="bt-arrow-action" href="/carrinho"> > </a>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row-request">
                <div class="info-request float-left">Frete</div>
                <div class="price-final float-right">
                    <span class="title-internal-15">{{ $shoppingCart->getShipping()->price }}</span>
                </div>
            </div>

            <div class="row-request">
                <div class="info-request float-left">Total</div>
                <div class="price-final float-right">
                    <span class="title-internal-15">{{ $shoppingCart->total }}</span>
                </div>
            </div>

        </article>

        <p class="title-internal-blue mbottom20">Endereço de Entrega</p>

        <article class="to-deliver section-payment template1">
            <div class="float-left">
                <span class="title-internal-15 uppercase">{{ $deliveryAddress->nickname }}</span>
                {!! $deliveryAddress->address_html !!}
            </div>
            <div class="float-right">
                <a class="bt-arrow-action" href="/checkout/entrega"> > </a>
            </div>
        </article>

        <p class="title-internal-blue mbottom30">Forma de pagamento</p>





        <div id="paymentTabs">

            <ul class="payment-methods">
                <li>
                    <a class="selected-methods" href="#tab-card">
                        Cartão de Credito
                        <div class="resp-arrow"></div>
                    </a>
                </li>
                <li>
                    <a href="#tab-transfer">
                        Depósito em Conta
                        <div class="resp-arrow"></div>
                    </a>
                </li>    
            </ul>

            <div class="height-fix" id="tab-card">
                <section class="form-payment section-payment height-fix">
                    @if($errors->has())
                    <p class="error-message">{{ $errors->first() }}</p>
                    @endif
                    <ul class="flags-card">
                        <!-- <div class="flags visa"></div> -->
                        @foreach ($paymentMethods as $paymentMethod)
                            @if ($paymentMethod->getDescription() == "credit_card")
                                <li class="flags-list">
                                    <label for="{{ $paymentMethod->getName() }}">
                                        <img class="flags" src="{{ asset_web('images/payment_methods/icon_' . $paymentMethod->getName() . '.png') }}" alt="">
                                    </label>
                                    {!! Form::radio('payment[method]', $paymentMethod->getId(), null, ['id' => $paymentMethod->getName()]) !!}
                                    {!! Form::input('hidden', 'payment[method_type]', $paymentMethod->getDescription(), null) !!}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="col-register1 template1">
                        <div class="user-data">
                            <h2 class="title-form">Parcelamento</h2>
                            <ul class="list-form-register">
                                <li>
                                    <div class="select-standard full form-control-white @if($errors->has('payment.installments')) error-field @endif">
                                        {!! Form::select('payment[installments]', $installmentOptions, null) !!}
                                    </div>
                                </li>
                                <li>
                                    <p>
                                        O limite disponível no cartão de crédito deve ser
                                        superior ao valor total da compra, e não ao
                                        valor de cada parcela.
                                    </p>
                                </li>
                            </ul>

                        </div>

                    </div>

                    <div class="col-register2 template1">

                        <div class="user-data">
                            <h2 class="title-form">Dados do cartão</h2>
                            <ul class="list-form-register">
                                <li>
                                    <label class="label-input" for="txtCardHoldername">Nome impresso do cartão *</label>
                                    {!! Form::text('card[holdername]', null, ['id' => 'txtCardHoldername', 'placeholder' => 'Nome impresso no cartão *', 'class' => 'input-register full ' . ($errors->has('card.holdername') ? 'error-field' : '')]) !!}
                                </li>
                                <li>
                                    <label class="label-input" for="txtCardNumber">Número do cartão *</label>
                                    {!! Form::text('card[number]', null, ['id' => 'txtCardNumber', 'placeholder' => 'Número do cartão *', 'class' => 'input-register full ' . ($errors->has('card.number') ? 'error-field' : '')]) !!}
                                </li>
                                <li>
                                    <label class="label-input" for="txtDocument">CPF / CNPJ *</label>
                                    {!! Form::text('document', null, ['id' => 'txtDocument', 'placeholder' => 'CPF / CNPJ *', 'class' => 'input-register full ' . ($errors->has('card.number') ? 'error-field' : '')]) !!}
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-register3 template1">
                        <div class="card-validity template1">
                            <ul class="list-form-register">
                                <li>
                                    <label class="label-above">Data de validade</label>
                                    <div class="select-standard width120 form-control-white @if($errors->has('card.expiry_month')) error-field @endif">
                                        {!! Form::select('card[expiry_month]', ['' => 'Mês'] + $months, null) !!}
                                    </div>
                                    <div class="select-standard width120 form-control-white @if($errors->has('card.expiry_year')) error-field @endif">
                                        {!! Form::select('card[expiry_year]', ['' => 'Ano'] + $years, null) !!}
                                    </div>
                                </li>
                                <li>
                                    <label class="label-above" for="">Código de segurança *</label>
                                    {!! Form::text('card[security_code]', null, ['id' => 'txtCardSecurityCode', 'class' => 'number input-register width120 ' . ($errors->has('card.number') ? 'error-field' : '')]) !!}
                                    <img class="float-left img-cod-seg" src="{{ asset_web('images/img-cod-seg.jpg') }}" alt="">
                                </li>
                            </ul>
                        </div>
                    </div>

                </section>

                <div class="wrap-content-bt remove-mbttom20">
                    <div class="content-bt-big">
                        <button class="bt-default-full bt-middle bt-color" href="#">Pagar <span class="arrow-link">&gt;</span></button>
                    </div>
                </div>
            </div> <!-- Fim tab-card -->
            <div class="height-fix" id="tab-transfer">
                <section class="form-payment section-payment template1" >
                    <ul class="flags-card">
                        @foreach ($paymentMethods as $paymentMethod)
                            @if ($paymentMethod->getDescription() == "account_deposit")
                                <li class="flags-list">
                                    <label for="{{ $paymentMethod->getName() }}">
                                        <img class="flags" src="{{ asset_web('images/payment_methods/icon_' . $paymentMethod->getName() . '.png') }}" alt="">
                                    </label>
                                    {!! Form::radio('payment[method]', $paymentMethod->getId(), null, ['id' => $paymentMethod->getName()]) !!}
                                    {!! Form::input('hidden', 'payment[method_type]', $paymentMethod->getDescription(), null) !!}
                                    <p>Deposito Bancário</p>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                    <p class="mbottom20"> CLIQUE NO BOTÃO ABAIXO PARA CONFIRMAR e receber as informações de depósito por e-mail.</p>

                    <p class="mbottom20"><strong>Atenção:</strong> Não efetue depósito sem nossa confirmação, os dados podem mudar conforme a expedição de envio de mercadorias, o que atrasaria seu processo em caso de divergência fiscal. É importante aguardar o recebimento do email com as instruções para o o depósito bancário.</p>
                </section>

                <div class="wrap-content-bt remove-mbttom20">
                    <div class="content-bt-big">
                        <button class="bt-default-full bt-middle bt-color" href="#">Pagar <span class="arrow-link">&gt;</span></button>
                    </div>
                </div>

            </div> <!-- Fim tab-transfer -->
        </div><!-- paymentTabs -->


    </section>

    {!! Form::close() !!}
</div>

@include('website::layouts.partials.checkoutfooter')


@stop
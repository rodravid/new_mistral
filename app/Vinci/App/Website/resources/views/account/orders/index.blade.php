@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('index') }}"><span>Meus pedidos</span></a>
    </li>
@endsection

@section('account.content')
    <div class="wrap-pag-header">

        <div class="container-total-products">
            <span class="total-products">1 - 15 de 350 produtos</span>
        </div>

        <ul class="pagination">
            <li>
                <a href="javascript:void(0);" class="selected">1</a>
            </li>
            <li>
                <a href="">2</a>
            </li>
            <li>
                <a href="">3</a>
            </li>
            <li>
                <a href="">4</a>
            </li>
            <li>
                <a href="">5</a>
            </li>
            <li>
                <a href="">></a>
            </li>
        </ul>

    </div>

    <section class="request section-request">

        <div class="row-request-account template11">

            <div class="col-request-account">

                <div class="num-request-account">
                    <p class="title-info-req">Número do pedido</p>
                    <span class="num-request-cod">12345678</span>
                </div>

                <div class="num-request-date">
                    <p class="title-info-req">Data do pedido</p>
                    <span class="title-txt-req">25/jan/2106</span>
                </div>

                <div class="num-request-price">
                    <p class="title-info-req">Valor</p>
                    <span class="title-txt-req">R$ 145,56</span>
                </div>

                <div class="num-request-status">
                    <p class="title-info-req">Status</p>
                    <span class="title-txt-req">Entregue 02/fev</span>
                </div>

                <div class="float-right mtop10">
                    <a class="bt-arrow-action" href="{{ route('account.orders.show', [1]) }}"> > </a>
                </div>

            </div>

        </div>

        <div class="row-request-account template11">

            <div class="col-request-account">

                <div class="num-request-account">
                    <p class="title-info-req">Número do pedido</p>
                    <span class="num-request-cod">12345678</span>
                </div>

                <div class="num-request-date">
                    <p class="title-info-req">Data do pedido</p>
                    <span class="title-txt-req">25/jan/2106</span>
                </div>

                <div class="num-request-price">
                    <p class="title-info-req">Valor</p>
                    <span class="title-txt-req">R$ 145,56</span>
                </div>

                <div class="num-request-status">
                    <p class="title-info-req">Status</p>
                    <span class="title-txt-req">Entregue 02/fev</span>
                </div>

                <div class="float-right mtop10">
                    <a class="bt-arrow-action" href="{{ route('account.orders.show', [1]) }}"> > </a>
                </div>

            </div>

        </div>

        <div class="row-request-account template11">

            <div class="col-request-account">

                <div class="num-request-account">
                    <p class="title-info-req">Número do pedido</p>
                    <span class="num-request-cod">12345678</span>
                </div>

                <div class="num-request-date">
                    <p class="title-info-req">Data do pedido</p>
                    <span class="title-txt-req">25/jan/2106</span>
                </div>

                <div class="num-request-price">
                    <p class="title-info-req">Valor</p>
                    <span class="title-txt-req">R$ 145,56</span>
                </div>

                <div class="num-request-status">
                    <p class="title-info-req">Status</p>
                    <span class="title-txt-req">Entregue 02/fev</span>
                </div>

                <div class="float-right mtop10">
                    <a class="bt-arrow-action" href="{{ route('account.orders.show', [1]) }}"> > </a>
                </div>

            </div>

        </div>

        <div class="row-request-account template11">

            <div class="col-request-account">

                <div class="num-request-account">
                    <p class="title-info-req">Número do pedido</p>
                    <span class="num-request-cod">12345678</span>
                </div>

                <div class="num-request-date">
                    <p class="title-info-req">Data do pedido</p>
                    <span class="title-txt-req">25/jan/2106</span>
                </div>

                <div class="num-request-price">
                    <p class="title-info-req">Valor</p>
                    <span class="title-txt-req">R$ 145,56</span>
                </div>

                <div class="num-request-status">
                    <p class="title-info-req">Status</p>
                    <span class="title-txt-req">Entregue 02/fev</span>
                </div>

                <div class="float-right mtop10">
                    <a class="bt-arrow-action" href="{{ route('account.orders.show', [1]) }}"> > </a>
                </div>

            </div>

        </div>


    </section>


    <div class="wrap-pag-header">

        <div class="container-total-products show-desktop">
            <span class="total-products ">1 - 15 de 350 produtos</span>
        </div>

        <ul class="pagination">
            <li>
                <a href="javascript:void(0);" class="selected">1</a>
            </li>
            <li>
                <a href="">2</a>
            </li>
            <li>
                <a href="">3</a>
            </li>
            <li>
                <a href="">4</a>
            </li>
            <li>
                <a href="">5</a>
            </li>
            <li>
                <a href="">></a>
            </li>
        </ul>

    </div>

@stop
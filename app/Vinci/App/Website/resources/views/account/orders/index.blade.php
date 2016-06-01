@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('index') }}"><span>Meus pedidos</span></a>
    </li>
@endsection

@section('account.content')

    @if($orders->count())
        <div class="wrap-pag-header">
            <div class="container-total-products">
                <span class="total-products">{{ $orders->range_view }} pedidos</span>
            </div>
            <ul class="pagination">
                {!! $orders->links() !!}
            </ul>
        </div>
    @endif

    <section class="request section-request">

        @forelse($orders as $order)

            <div class="row-request-account template11">

                <div class="col-request-account">

                    <div class="num-request-account">
                        <p class="title-info-req">Número do pedido</p>
                        <span class="num-request-cod">{{ $order->number }}</span>
                    </div>

                    <div class="num-request-date">
                        <p class="title-info-req">Data do pedido</p>
                        <span class="title-txt-req">{{ $order->creation_date }}</span>
                    </div>

                    <div class="num-request-price">
                        <p class="title-info-req">Valor</p>
                        <span class="title-txt-req">{{ $order->total }}</span>
                    </div>

                    <div class="num-request-status">
                        <p class="title-info-req">Status</p>
                        <span class="title-txt-req">{{ $order->status }}</span>
                    </div>

                    <div class="float-right mtop10">
                        <a class="bt-arrow-action" href="{{ route('account.orders.show', [$order->id]) }}"> > </a>
                    </div>

                </div>

            </div>

        @empty

            <h2>Olá {{ $loggedUser->name }}, você não tem pedidos recentes. </h2><br />
            Os detalhes dos seus próximos pedidos poderão ser acompanhados nesta área.

        @endforelse
    </section>


    @if($orders->count())
        <div class="wrap-pag-header">
            <div class="container-total-products show-desktop">
                <span class="total-products ">{{ $orders->range_view }} pedidos</span>
            </div>

            <ul class="pagination">
                {!! $orders->links() !!}
            </ul>
        </div>
    @endif
@stop
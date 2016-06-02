@extends('website::account.layouts.master')

@section('account.breadcrumb')
    <li class="breadcrumb-item">
        <a class="breadcrumb-link" href="{{ route('account.favorite.index') }}"><span>Favoritos</span></a>
    </li>
@endsection

@section('account.content')

    <div class="wrap-pagination-favorites">

        @if ((! $favorites->count() && !empty($keyword)) || $favorites->count())
            <div class="search-internal">
                {!! Form::open(['route' => 'account.favorite.index', 'method' => 'GET']) !!}
                <input type="search" placeholder="Buscar" name="termo" class="input-serach-internal" value={{ $keyword }}>
                <input type="submit" class="sprite-icon bt-search-internal" value="">
                {!! Form::close() !!}
            </div>
        @endif

        @if ($favorites->count())
            <div class="container-left-pag">
                <div class="container-total-products">
                    <span class="total-products show-desktop">{{ $favorites->range_view }} produtos</span>
                </div>

                <ul class="pagination">
                    {{ $favorites->links() }}
                </ul>
            </div>
        @endif

    </div>

    @if ($favorites->count())

        <article class="wrap-content-four-line template4">

            @each('website::layouts.partials.product.cards.default', $favorites, 'product')

        </article>

        <div class="container-total-products">
            <span class="total-products show-desktop">{{ $favorites->range_view }} produtos</span>
        </div>

        <ul class="pagination">
            {{ $favorites->links() }}
        </ul>

    @else

        @if (! $favorites->count() && empty($keyword))

            <h2>Você ainda não possui produtos em sua lista de favoritos.</h2>
            <p>A lista de favoritos é uma ferramenta que ajuda na organização dos nossos produtos que são de seu interesse e você pode adicionar qualquer item à venda em nosso site à sua lista de favoritos.</p>

        @else

            <h2>Nenhum produto encontrado.</h2>

        @endif

    @endif

@endsection
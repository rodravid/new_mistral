@extends('website::search.partials.box')

@section('box_class', 'column-products-search-inline')

@section('search.content')

    @each('website::layouts.partials.product.cards.search', $result->getItems(), 'product')

@endsection
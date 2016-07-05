@extends('website::search.partials.box')

@section('box_class', 'column-products-search-category')

@section('search.content')

    @each('website::layouts.partials.product.cards.default', $result->getItems(), 'product')

@endsection
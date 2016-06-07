@extends('website::search.partials.box')

@section('search.content')

    @each('website::layouts.partials.product.cards.search', $result->getItems(), 'product')

@endsection
@extends('website::search.partials.box')

@section('search.content')

@each('website::layouts.partials.product.cards.default', $result->getItems(), 'product')

@endsection
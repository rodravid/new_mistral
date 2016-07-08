@extends('website::layouts.emails.templates.default')

@section('body')

    Olá {{ $customer->name }}

@endsection
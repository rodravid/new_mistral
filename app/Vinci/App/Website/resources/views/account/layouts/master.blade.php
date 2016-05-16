@extends('website::layouts.master')

@section('content')
    <div class="header-internal template4-bg">
        @include('website::layouts.menu')
        <div class="row">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="{{ route('index') }}"><span>Início</span></a> >
                </li>
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="javascript:void(0);"><span>Minha conta</span></a> >
                </li>

                @yield('account.breadcrumb')
            </ul>

            <h1 class="internal-subtitle">Minha conta</h1>
        </div>
    </div>

    @include('website::account.partials.menu')

    <div class="row">

        @yield('account.content')

    </div>

    <div class="border-footer">
        @include('website::layouts.footer')
    </div>

@stop
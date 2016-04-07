@extends('cms::layouts.master')

@section('content')

    <section class="content-header">
        <h1><span class="{{ $currentModule->getIcon() }}"></span> {{ $currentModule->getTitle() }}</h1>
        @yield('breadcrumb')
    </section>

    @yield('module.content')

@endsection
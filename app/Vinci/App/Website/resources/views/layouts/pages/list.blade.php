@extends('website::layouts.master')

@section('title', 'Vinci - ')

@section('content')
    <div class="header-internal {{ $template }}-bg bg-color-category" style="background: url({{ asset_web('images/' . $imageTitle) }}) no-repeat top right;">
        @include('website::layouts.menu')
        <div class="row">
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="breadcrumb-link" href="/"><span>Início</span></a> >
                </li>
                <li class="breadcrumb-item">
                    <span>{{ $pageTitle }}</span>
                </li>
            </ul>

            <h1 class="internal-subtitle-category">Vinhos por {{ $pageTitle }}</h1>
            <div class="container-leia-mais">
                <p class="category-description">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae blanditiis
                    cum cumque deserunt dolor eveniet explicabo hic incidunt, inventore ipsa ipsum iusto
                    laborum laudantium magnam officia praesentium similique sunt totam? Lorem ipsum dolor sit amet,
                    consectetur adipisicing elit. Aliquid et nulla quos. Ad aliquid deserunt, doloremque earum esse est explicabo
                    itaque laborum magni nesciunt quae quasi quia, saepe temporibus voluptatibus.
                </p>
            </div>
        </div>
    </div>

    <div class="row {{ $template }}">
        <ul class="alphabet-list">
            {!! makeAlphabet($resources->getAvailableLetters()) !!}
        </ul>

        @foreach($resources->groupByLetters()->chunk(4) as $group)
            <div class="line-category">

                @foreach($group as $resourceGroup)
                    <ul class="line-category-content" id="{{ $resourceGroup->letter }}">

                        <h3 class="title-line-category">{{ $resourceGroup->letter }}</h3>

                        @foreach($resourceGroup->items as $item)
                            <li class="item-line-category">
                                <a class="link-line-category" href="{{ route('category.' . $resourceType . '.show', [$item->getSlug()]) }}">{{ $item->getName() }}</a>
                            </li>
                        @endforeach

                    </ul>
                @endforeach

            </div>
        @endforeach

    </div>

    @include('website::layouts.footer')

@stop
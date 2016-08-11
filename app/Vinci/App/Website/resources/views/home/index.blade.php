@extends('website::layouts.master')

@section('content')
    @include('website::layouts.menu')

    <div ng-controller="HomeController">

        <div class="wrap-slider-principal">

            <div class="slider slider-principal" tabindex="1">

                @foreach($highlights as $highlight)

                    <div class="bg-slider-principal {{ $highlight->template }}">
                        <div class="conteudo-slider-principal"
                             @if($highlight->hasImage('desktop')) style="background: url({{ $highlight->getImage('desktop')->getWebPath() }}) no-repeat;" @endif>
                            <a class="link-banner-slider" href="{{ $highlight->url }}" target="{{ $highlight->target }}">
                            </a>
                            <div class="descr-slider">

                                    <h3 class="title-slider">{!! $highlight->title !!}</h3>
                                    <span class="sub-title-slider">{!! $highlight->subtitle !!}</span>
                                    <p class="txt-slider">{!! $highlight->description !!}</p>

                                <a href="{{ $highlight->url }}" target="{{ $highlight->target }}" class="bt-default">Clique aqui 
                                    <span class="arrow-link">></span>
                                </a>
                            </div>
                         
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
        <div class="w960">
        </div>


        <section class="titles-category-fixed">

        </section>

        <section class="wrap-price-range">
            <div class="row">
                <p class="title-15 mbottom10 uppercase">Vinhos por faixa de preço (R$)</p>
                <ul class="list-button-price">
                    <li class="item-button-price">
                        <a href="/busca?preco%5B%5D=*-60" class="bt-default-full template13">Até 60 <span class="arrow-link">></span></a>
                    </li>
                    <li class="item-button-price">
                        <a href="/busca?preco%5B%5D=60-100" class="bt-default-full template13">60 a 100 <span class="arrow-link">></span></a>
                    </li>
                    <li class="item-button-price">
                        <a href="/busca?preco%5B%5D=100-170" class="bt-default-full template13">100 a 170 <span class="arrow-link">></span></a>
                    </li>
                    <li class="item-button-price">
                        <a href="/busca?preco%5B%5D=170-270" class="bt-default-full template13">170 a 270 <span class="arrow-link">></span></a>
                    </li>
                    <li class="item-button-price">
                        <a href="/busca?preco%5B%5D=270-500" class="bt-default-full template13">270 a 500 <span class="arrow-link">></span></a>
                    </li>
                    <li class="item-button-price">
                    <a href="/busca?preco%5B%5D=500-*" class="bt-default-full template13">Acima de 500 <span class="arrow-link">></span></a>
                    </li>
                </ul>
            </div>
        </section>

        <div class="row">

            <section class="wrap-banners">
                <ul class="banners">

                    @foreach($banners as $banner)

                        @if ($banner->hasImage('desktop'))
                            <li class="list-banners">
                                <a href="{{ $banner->url }}" target="{{ $banner->target }}"><img src="{{ $banner->getImage('desktop')->getWebPath() }}" alt="{{ $banner->title }}"></a>
                            </li>
                        @endif

                    @endforeach

                </ul>

            </section>


            <section class="featured-products" showcase-container>

                @foreach($showcases as $showcase)

                    <showcase-widget showcase-id="{{ $showcase->id }}" load-first="true" class="cols-products {{ $showcase->getTemplate()->getCode() }}">
                        <div class="container-titlecat">
                            <div class="center-height">
                                <a href="{{ $showcase->link }}"><h2 class="title-category">{{ $showcase->title }}</h2></a>
                            </div>
                        </div>

                        <div class="container-products"></div>
                        <div class="loading-container mbottom10">
                            <img src="{{ asset_web('images/loading.gif') }}" alt="Carregando..." class="loading_gif">
                        </div>
                        <button type="button" class="show-mobile loadProducts {{ $showcase->getTemplate()->getCode() }} bt-default-full" ng-click="loadProducts()">Carregar mais vinhos <span class="arrow-link">v</span></button>
                    </showcase-widget>
                @endforeach

                <button id="btnShowcaseLoadMore" type="button" class="bt-default-full template7 show-desktop mtop10" ng-click="loadMore()">Carregar mais produtos <span class="arrow-link">v</span></button>
            </section>
            @include('website::layouts.partials.featuredweek')
        </div>

    </div>

    @include('website::layouts.footer')

@endsection

@section("scripts")

    @parent

    <script>

        (function ($) {

            var $window = $(window);


            function eDesktop() {
                var larguraTela = $window.width();

                if (larguraTela > 970) {
                    return true;
                } else {
                    return false;
                }
            }

            function removeMenuFixo() {
                $(".header-main").removeClass('menu-fixo').removeClass('opacity1');
                $(".menu-fixo").fadeOut();
                $("body").css("margin-top", "0px");
            }

            function getLastFeaturedBoxOffset() {
                return $('.featured-products').find('.cols-products:first').find('.wine-card:last').offset();
            }

            var h = $(".container-titlecat").height();

            function toggleTitleCategory(action) {


                if (action == 'show') {

                    $(".container-titlecat").addClass('category-fixed');
                    $(".category-fixed").addClass('opacity1');
                    $(".titles-category-fixed").addClass('category-fixed').css("display", "inline-block");

                    $('.cols-products').css({'margin-top': h + 'px'});

                } else {


                    $(".container-titlecat").removeClass('category-fixed');
                    $(".container-titlecat").removeClass('opacity1');
                    $(".titles-category-fixed").removeClass('category-fixed').css("display", "none");

                    $('.cols-products').css({'margin-top': '0px'});

                }

            }

            function getSliderHeight() {
                return $('.wrap-slider-principal').height();
            }

            $('body').delegate('.menu-fixo', 'mouseenter', function () {
                $('.menu-main').slideDown();
                $(".category-fixed").css("top", "100px");
            });


            $window.scroll(function () {

                var scrollTop = $window.scrollTop();
                var lastBoxOffsetTop = getLastFeaturedBoxOffset().top;


                if (eDesktop()) {


                    if (scrollTop > 200) {
                        $(".menu-main").slideUp();
                    } else {
                        $(".menu-main").show();
                    }

                    if (scrollTop >= 465) {

                        //$(".menu-main").slideUp();

                        $(".header-main").addClass('menu-fixo');

                        $(".menu-fixo").fadeIn(400, function () {
                            // $("body").css("margin-top", "100px");
                        });

                        $(".category-fixed").css("top", "70px");


                        $(".menu-fixo").addClass('opacity1');

                    } else {
                        removeMenuFixo();
                    }

                } else {
                    removeMenuFixo();
                }

                if (eDesktop()) {

                    if (scrollTop >= 780 && scrollTop < lastBoxOffsetTop) {

                        toggleTitleCategory('show');

                    } else {

                        toggleTitleCategory('hide');

                    }

                } else {
                    toggleTitleCategory('hide');
                }


            }).scroll();

        })($);

    </script>

@endsection



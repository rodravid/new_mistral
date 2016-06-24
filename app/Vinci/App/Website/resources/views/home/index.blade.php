@extends('website::layouts.master')

@section('content')
    @include('website::layouts.menu')

    <div ng-controller="HomeController">

        <div class="wrap-slider-principal">

            <div class="slider slider-principal">

                @foreach($highlights as $highlight)

                    <div class="bg-slider-principal {{ $highlight->template }}">
                        <div class="conteudo-slider-principal"
                             @if($highlight->hasImage('desktop')) style="background: url({{ $highlight->getImage('desktop')->getWebPath() }}) no-repeat;" @endif>
                            <div class="descr-slider">
                                <a href="{{ $highlight->url }}" target="{{ $highlight->target }}">
                                    <h3 class="title-slider">{!! $highlight->title !!}</h3>
                                    <span class="sub-title-slider">{!! $highlight->subtitle !!}</span>
                                    <p class="txt-slider">{!! $highlight->description !!}</p>
                                </a>
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

        <div class="row top90">

            <section class="wrap-banners">
                <ul class="banners">

                    @foreach($banners as $banner)

                        @if ($banner->hasImage('desktop'))
                            <li class="list-banners">
                                <img src="{{ $banner->getImage('desktop')->getWebPath() }}" alt="{{ $banner->title }}">
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
                        <div class="container-products">

                        </div>

                        <button type="button" class="show-mobile loadProducts {{ $showcase->getTemplate()->getCode() }} bt-default-full" ng-click="loadProducts()">Carregar mais vinhos <span class="arrow-link">v</span></button>
                    </showcase-widget>
                @endforeach

                <button id="btnShowcaseLoadMore" type="button" class="bt-default-full template7 show-desktop" ng-click="loadMore()">Carregar mais produtos <span class="arrow-link">v</span></button>
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
            // alert(h);



            // if (h <= 45) {
            //     $(".titles-category-fixed").css({'height': '36px'});
            // } else {
            //     $(".titles-category-fixed").css({'height': '56px'});
            // }

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
                            $("body").css("margin-top", "100px");
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

                    if (scrollTop >= 686 && scrollTop < lastBoxOffsetTop) {

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



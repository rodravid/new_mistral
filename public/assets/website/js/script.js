jQuery(document).ready(function ($) {


    $('.js-typeahead').typeahead({

        dynamic: true,

        minLength: 0,

        hint: true,

        resultContainer: '#suggestion-result',

        source: {
            products: {
                display: ["title", "country", "producer", 'url'],
                ajax: {
                    url: '/api/search/suggest',
                    data: {
                        q: '{{query}}'
                    }
                },
                template: function(query, item) {

                    return '<a href="{{url|raw}}" class="suggestions-link">' +
                        '{{title|raw}}' +
                        '<p>{{producer|raw}} / {{country|raw}}</p>' +
                        '</a>';
                }
            }
        },

        selector: {
            result: 'results-suggestions',
            list: 'suggestions-list'
        },

        callback: {
            onResult: function (node, query, result, resultCount, resultCountPerGroup) {

                if (resultCount > 0) {

                    $('.results-suggestions').fadeIn();

                } else {
                    $('.results-suggestions').hide();
                }
            }
        }

    });


    $('.slider-principal').slick({
        dots: true,
        autoplay: true,
        autoplaySpeed: 8000,
        arrow: false,
        touchMove: false,
        responsive: [
            {
                breakpoint: 1100,
                settings: {
                    touchMove: true,
                    dots: true,
                }
            }
        ]

    });
    $('.slick-dots').appendTo('.w960');
    // $('.slick-prev, .slick-next').appendTo('.setas-slider-principal');

    //$(".favorite").click(function (event) {
    //    if ($(this).hasClass('clicado')) {
    //        $(this).removeClass('clicado');
    //        $(this).removeClass('opacity1');
    //    } else {
    //        $(this).addClass('clicado');
    //        $(this).addClass('opacity1');
    //    }
    //});


    $(".favorite-product").click(function (event) {
        if ($(this).hasClass('click-fav')) {
            $(this).removeClass('click-fav');
        } else {
            $(this).addClass('click-fav');
        }
    });


    $('.filter-search').each(function () {
        if ($(this).children('li').length > 5) {
            $(this).find("li:nth-child(1n+7)").css("display", "none");
            $(this).find(".see-more-filter").show();
        }
        else {
            $(this).find(".see-more-filter").hide();
        }
    });

    $(".see-more-filter").click(function (event) {
        if ($(this).hasClass('see-less-filter')) {
            $(this).siblings(".filter-search li:nth-child(1n+7)").css("display", "none");
            $(this).text('+ veja mais').addClass('see-more-filter').removeClass('see-less-filter');
        } else {
            $(this).siblings(".filter-search li:nth-child(1n+7)").css("display", "inline-block");
            $(this).text('- veja menos').addClass('see-less-filter').removeClass('see-more-filter');
        }
    });

    $(".ver-mais-det-vinhos").click(function (event) {
        $(".mais-info-vinho").slideDown();
        $(".ver-mais-det-vinhos").hide();
        $(".ver-menos-det-vinhos").show();
    });

    $(".ver-menos-det-vinhos").click(function (event) {
        $(".mais-info-vinho").slideUp();
        $(".ver-menos-det-vinhos").hide();
        $(".ver-mais-det-vinhos").show();
    });


    // $('.details-wine').each(function () {
    //   if ($(this).children('li').length > 9) {
    //     $(this).find("li:nth-child(1n+11)").css("display", "none");
    //     $(this).find(".see-more-filter").show();
    //   }
    //   else {
    //     $(this).find(".see-more-filter").hide();
    //   }
    // });

    //     $(".see-more-info").click(function (event) {
    //   if ($(this).hasClass('see-less-info')) {
    //     $(this).siblings(".details-wine li:nth-child(1n+11)").css("display", "none");
    //     $(this).text('Veja mais').addClass('see-more-info').removeClass('see-less-info');
    //   } else {
    //     $(this).siblings(".details-wine li:nth-child(1n+11)").css("display", "inline-block");
    //     $(this).text('Veja menos').addClass('see-less-info').removeClass('see-more-info');
    //   }
    // });

    $(".see-more-info").click(function (event) {
        if ($(this).hasClass('see-less-info')) {
            $(this).text('Veja mais').addClass('see-more-info').removeClass('see-less-info');
            $(".rule-details-wine").slideUp();
        } else {
            $(this).text('Veja menos').addClass('see-less-info').removeClass('see-more-info');
            $(".rule-details-wine").slideDown();
        }
    });


    $(".name-seals-description").click(function (event) {

        $(this).siblings(".seals-description li div").slideToggle(200);
    });


    $(".description-toogle").click(function (event) {
        $(this).toggleClass('open');
        $(this).siblings(".invert-mobile2 span").slideToggle(200);
    });


    var $boxColuna1 = $('.search-column');
    var $boxColuna2 = $('.column-products-search-inline, .column-products-search-category');
    var originalHeightCol1 = $boxColuna1.height();

    function heightColuna1() {

        var heightCol1 = $boxColuna1.height();
        var heightCol2 = $boxColuna2.height();

        $boxColuna1.css('height', heightCol1 > heightCol2 ? heightCol1 : heightCol2);
    }

    $(window).load(function () {
        setTimeout(function () {
            heightColuna1();
        }, 1000);
    });


    $(".filtro-mobile").click(function (event) {
        $(".search-column").removeClass('opacidade-coluna1').addClass('semopacidade-coluna1');
        $(".bg-layer-filtro").fadeIn();
        $(".filtro-mobile").css("z-index", "0");
    });
    $(".bg-layer-filtro").click(function (event) {
        $(".search-column").removeClass('semopacidade-coluna1').addClass('opacidade-coluna1');
        $(".bg-layer-filtro").fadeOut();
        $(".filtro-mobile").css("z-index", "9999999");
    });


    if (navigator.appVersion.indexOf("Win") != -1)$("body").addClass("wind");
    if (navigator.appVersion.indexOf("Mac") != -1)$("body").addClass("mac");


    $('input, textarea').placeholder();

    // $(".data").mask("99/99/9999");
    // $(".cpf").mask("999.999.999-99");
    // $(".birth-date").mask("99/99/9999");
    // $(".phone").mask("(99) 9999-9999");
    // $(".cel").mask("(99) 99999-9999");
    // $(".cep").mask("99999-999");

    $("[date]").inputmask("99/99/9999");
    $("[cpf]").inputmask("999.999.999-99");
    $("[cnpj]").inputmask("99.999.999/9999-99");
    $("[phone-mask]").inputmask("(99) 9999-9999[9]");  //static mask
    $("[cep]").inputmask("99999-999");


    $('.call-login').on('click', function () {
        $('.overlay, .modal-login').fadeIn();
    });

    $('.call-recovery').on('click', function () {
        $('.overlay, .modal-recovery').fadeIn();
        $('.modal-login').fadeOut();
    });

    $('body').delegate('.close, .overlay', 'click', function () {
        $('.overlay, .modal-login, .modal-recovery, .modal-adress, .global-modal, .modal-delivery-time, .modal-gift').fadeOut();
    });

    $('.call-adress').on('click', function () {

        var $self = $(this);
        var addressId = $self.data('address-id');
        var $modalWrapper = $('body').find("#current-modal");

        $.ajax({
            type: 'GET',
            url: '/minhaconta/enderecos/modal',
            dataType: 'html',
            data: {
                address_id: addressId
            },
            success: function(response) {

                //var $modal = $(response);

                $modalWrapper.html(response);

                var $modal = $modalWrapper.find('.global-modal');

                $modal.fadeIn();
                $('body').find('.overlay, .modal-larger, .global-modal').fadeIn();

            }
        });

    });

    $('.content-term-delivery').on('click', function () {
        $('.overlay, .modal-delivery-time').fadeIn();
    });


    $('body').delegate(".gift",'click', function () {
            // $modal.fadeIn();
                $('body').find('.overlay, .modal-larger, .global-modal, .modal-gift').fadeIn();
    });

    $('.slider-gift').slick({
     slidesToShow: 3,
     dots: true,
      responsive: [
    {
      breakpoint: 800,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1
      }
    }
  ]
 });


    $('.flags-list .flags').bind('click', function() {
        var $self = $(this);
        var $container = $self.parents('.flags-list');
        var identifier = $self.attr('class').split(' ')[1];

        $container.find('input.' + identifier).prop('checked', true);
    });

    //$('input[name=type-buyer]').on('change', function () {
    //
    //    var $self = $(this);
    //    var value = $self.val();
    //
    //    if (value == 1) {
    //
    //        $("#person").fadeIn();
    //        $("#company").hide();
    //
    //    } else if (value == 2) {
    //
    //        $("#company").fadeIn();
    //        $("#person").hide();
    //
    //    }
    //
    //});
    //
    //function toggleTypeBuyer() {
    //
    //    var $self = $(this);
    //    var value = $('input[name=type-buyer]').val();
    //
    //    if (value == 1) {
    //
    //        $("#person").fadeIn();
    //        $("#company").hide();
    //
    //    } else if (value == 2) {
    //
    //        $("#company").fadeIn();
    //        $("#person").hide();
    //        $("#residencial").hide();
    //        $("#outros").hide();
    //
    //
    //    }
    //
    //}
    //
    //toggleTypeBuyer();


    $(".menu-account-mob").click(function () {

        var $self = $(this);

        if (! $(this).hasClass('open-menu')) {
            $(".menu-account-data").show();
            $(".current-account-data").hide();
            $self.find('p').text($(".current-account-data").text());
            $(".menu-account-mob").addClass('open-menu');

        } else {
            $(".menu-account-data, .current-account-data").hide();
            $(".menu-account-mob").removeClass('open-menu');
        }
    });

    $(".menu-account-mob").find('p').text($(".current-account-data").text());


    //  $(".physical-person").click(function () { //when click on flip radio button
    //   $('.physical-person:radio[name=type-buyer]').prop('checked', true);
    //   $('.legal-person:radio[name=type-buyer]').prop('checked', false);

    //   $("#person").fadeIn();
    //   $("#company").fadeOut();

    // });

    // $(".legal-person").click(function () { //when click on flip radio button
    //   $('.legal-person:radio[name=type-buyer]').prop('checked', true);
    //   $('.physical-person:radio[name=type-buyer]').prop('checked', false);

    //   $("#company").fadeIn();
    //   $("#person").fadeOut();
    // });


    $(".input-register, .field-txt").keyup(function (event) {
        var $self = $(this);

        var $label = $('label[for="' + $self.attr('id') + '"]');

        $self.val().length > 0 ? $label.fadeIn() : $label.fadeOut();

    }).keyup();


    // accordion
    $(".click-accordion").click(function (event) {

        if (!$(this).hasClass('aberto')) {
            $(this).siblings(".conteudo-accordion").slideDown(200);
            $(this).addClass('aberto');
            $(this).children(".seta-accordion-interna").removeClass('arrow-down').addClass('arrow-up');

        } else {

            $(this).siblings(".conteudo-accordion").slideUp(200);
            $(this).removeClass('aberto');
            $(this).children(".seta-accordion-interna").addClass('arrow-down').removeClass('arrow-up');
        }
    });

    $('.container-leia-mais').readmore({
        speed: 100,
        collapsedHeight: 70,
        moreLink: '<a href="javascript:void(0);" class="more-txt">+ Veja mais</a>',
        lessLink: '<a href="javascript:void(0);" class="less-txt">- Veja menos </a>'
    });

    $('#paymentTabs').responsiveTabs({
        startCollapsed: 'accordion'
    });


});


/*Detect IE add Class*/
;(function (ua, d) {
    if (/MSIE (9|10|11)/.test(ua) || /[like Gecko]$/.test(ua)) {
        d.body.className += (/[like Gecko]$/.test(ua) ? 'ie-edge' : /MSIE 11/.test(ua) ? 'ie-11' : /MSIE 10/.test(ua) ? 'ie-10' : 'ie-9');
    }
})(navigator.userAgent, document);




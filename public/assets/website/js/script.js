jQuery(document).ready(function ($) {

  $('.slider-principal').slick({
    dots: true,
    autoplay: true,
    autoplaySpeed: 8000,
    arrow: false,

  });
  $('.slick-dots').appendTo('.w960');
    // $('.slick-prev, .slick-next').appendTo('.setas-slider-principal');

    $(".favorite").click(function(event) {
      if ($(this).hasClass('clicado')){
       $(this).removeClass('clicado');
       $(this).removeClass('opacity1');
     }else{
       $(this).addClass('clicado');
       $(this).addClass('opacity1');
     }
   });


    $(".favorite-product").click(function(event) {
      if ($(this).hasClass('click-fav')){
       $(this).removeClass('click-fav');
     }else{
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



    $('.details-wine').each(function () {
      if ($(this).children('li').length > 9) {
        $(this).find("li:nth-child(1n+11)").css("display", "none");
        $(this).find(".see-more-filter").show();
      }
      else {
        $(this).find(".see-more-filter").hide();
      }
    });

    $(".see-more-info").click(function (event) {
      if ($(this).hasClass('see-less-info')) {
        $(this).siblings(".details-wine li:nth-child(1n+11)").css("display", "none");
        $(this).text('Veja mais').addClass('see-more-info').removeClass('see-less-info');
      } else {
        $(this).siblings(".details-wine li:nth-child(1n+11)").css("display", "inline-block");
        $(this).text('Veja menos').addClass('see-less-info').removeClass('see-more-info');
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

    $(".data").mask("99/99/9999");
    $(".cpf").mask("999.999.999-99");
    $(".birth-date").mask("99/99/9999");
    $(".phone").mask("(99) 9999-9999");
    $(".cel").mask("(99) 99999-9999");
    $(".cep").mask("99999-999");



    $('.call-login').on('click', function(){
      $('.overlay, .modal-login').fadeIn();
    });

    $('.call-recovery').on('click', function(){
      $('.overlay, .modal-recovery').fadeIn();
      $('.modal-login').fadeOut();
    });

    $('.close, .overlay').on('click', function(){
      $('.overlay, .modal-login, .modal-recovery').fadeOut();
    });



       $(".visa").click(function () { //when click on flip radio button
        $('.visa:radio[name=flag-card]').prop('checked', true);
        $('.master:radio[name=flag-card]').prop('checked', false);
        $('.american:radio[name=flag-card]').prop('checked', false);
        $('.diners:radio[name=flag-card]').prop('checked', false);
      });

              $(".master").click(function () { //when click on flip radio button
                $('.master:radio[name=flag-card]').prop('checked', true);
                $('.visa:radio[name=flag-card]').prop('checked', false);
                $('.american:radio[name=flag-card]').prop('checked', false);
                $('.diners:radio[name=flag-card]').prop('checked', false);
              });

                            $(".american").click(function () { //when click on flip radio button
                              $('.american:radio[name=flag-card]').prop('checked', true);
                              $('.visa:radio[name=flag-card]').prop('checked', false);
                              $('.master:radio[name=flag-card]').prop('checked', false);
                              $('.diners:radio[name=flag-card]').prop('checked', false);
                            });


                                                        $(".diners").click(function () { //when click on flip radio button
                              $('.diners:radio[name=flag-card]').prop('checked', true);
                              $('.visa:radio[name=flag-card]').prop('checked', false);
                              $('.master:radio[name=flag-card]').prop('checked', false);
                              $('.american:radio[name=flag-card]').prop('checked', false);
                            });



                          });


/*Detect IE add Class*/
; (function (ua, d) {
  if (/MSIE (9|10|11)/.test(ua) || /[like Gecko]$/.test(ua)) {
    d.body.className += (/[like Gecko]$/.test(ua) ? 'ie-edge' : /MSIE 11/.test(ua) ? 'ie-11' : /MSIE 10/.test(ua) ? 'ie-10' : 'ie-9');
  }
})(navigator.userAgent, document);




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


  });


/*Detect IE add Class*/
; (function (ua, d) {
  if (/MSIE (9|10|11)/.test(ua) || /[like Gecko]$/.test(ua)) {
    d.body.className += (/[like Gecko]$/.test(ua) ? 'ie-edge' : /MSIE 11/.test(ua) ? 'ie-11' : /MSIE 10/.test(ua) ? 'ie-10' : 'ie-9');
  }
})(navigator.userAgent, document);




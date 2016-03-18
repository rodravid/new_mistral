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
   






    if (navigator.appVersion.indexOf("Win") != -1)$("body").addClass("wind");
    if (navigator.appVersion.indexOf("Mac") != -1)$("body").addClass("mac");



});





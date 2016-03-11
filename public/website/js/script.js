jQuery(document).ready(function ($) {

    $('.slider-principal').slick({
        dots: true,
        autoplay: true,
        autoplaySpeed: 8000,
        arrow: false,

    });
    $('.slick-dots').appendTo('.w960');
    // $('.slick-prev, .slick-next').appendTo('.setas-slider-principal');

   






    if (navigator.appVersion.indexOf("Win") != -1)$("body").addClass("wind");
    if (navigator.appVersion.indexOf("Mac") != -1)$("body").addClass("mac");



});





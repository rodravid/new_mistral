var elixir = require('laravel-elixir');
//var bowerDir = 'vendor/bower_components/';

elixir(function(mix) {

    mix.scripts([
        'js/angular/angular.min.js',
        'js/angular/angular-locale_pt-br.js',
        'js/angular/angular-counter.min.js',
        'js/jquery-1.9.1.min.js',
        'js/slick.js',
        'js/sweetalert/sweetalert.min.js',
        'js/readmore.min.js',
        'js/input-mask/jquery.inputmask.js',
        'js/input-mask/jquery.inputmask.extensions.js',
        'js/jquery.placeholder.js',
        '../../assets/common/js/address-autocomplete.js',
        'js/script.js',
        'app/js/vendor/jquery.query-object.js',
        'app/js/vendor/URI.min.js',
        'app/js/app.js',
        'app/js/services/auth.js',
        'app/js/services/cart.js',
        'app/js/services/favorite.js',
        'app/js/controllers/home/homeController.js',
        'app/js/controllers/auth/modalLoginController.js',
        'app/js/controllers/auth/modalPasswordController.js',
        'app/js/controllers/product/productPageController.js',
        'app/js/controllers/register/registerController.js',
        'app/js/controllers/address/addressModalController.js',
        'app/js/directives/cart/cartItem.js',
        'app/js/directives/cart/cartAddButton.js',
        'app/js/directives/product/favoriteWidget.js',
        'app/js/controllers/cart/cartController.js',
        'app/js/controllers/cart/cartWidgetController.js',
        'app/js/controllers/search/search-filters-controller.js',
        'app/js/directives/search/search-filters-directive.js',
        'app/js/showcase/directives/showcase-container-directive.js',
        'app/js/showcase/directives/showcase-widget-directive.js',
    ],
        'public/assets/website/js', 'public/assets/website');
});

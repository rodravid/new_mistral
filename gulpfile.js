var elixir = require('laravel-elixir');

elixir(function(mix) {

    mix.sass([
        './app/Vinci/App/Website/resources/assets/sass/style.scss'
    ], 'public/assets/website/css/style.min.css');

    mix.scripts([
        'js/angular/angular.min.js',
        'js/angular/angular-locale_pt-br.js',
        'js/angular/angular-counter.min.js',
        'js/jquery-1.9.1.min.js',
        'js/slick.js',
        'js/jquery.responsiveTabs.min.js',
        'js/sweetalert/sweetalert.min.js',
        'js/readmore.min.js',
        'js/input-mask/jquery.inputmask.js',
        'js/input-mask/jquery.inputmask.extensions.js',
        'js/jquery.placeholder.js',
        'js/jquery-typeahead/dist/jquery.typeahead.min.js',
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
        'app/js/directives/search/search-suggestion-directive.js',
        'app/js/showcase/directives/showcase-container-directive.js',
        'app/js/showcase/directives/showcase-widget-directive.js',
        'app/js/newsletter/directives/newsletter-widget-directive.js',
        'app/js/newsletter/services/newsletter-service.js',

        'app/js/shipping/directives/shippingDeadline-widget-directive.js',
        'app/js/shipping/services/shippingDeadline-service.js',
        
        'js/angular/angular-input-masks/releases/angular-input-masks-standalone.min.js',
    ],
        'public/assets/website/js', 'public/assets/website');


    mix.phpSpec(elixir.config.testing.phpSpec.path + '/**/*Spec.php', 'bin/phpspec run');

});

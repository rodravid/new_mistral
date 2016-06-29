angular.module('app')
    .controller('CartController', ['$rootScope', '$cacheFactory', 'CartService', function($rootScope, $cacheFactory, cartService) {

        var self = this;

        $rootScope.postalCode = '';

        self.cart = {};

        self.showLoadingGif = function() {
            $(".loading_gif").prop('style', 'display: block;');
        };

        self.hideLoadingGif = function() {
            $(".loading_gif").prop('style', 'display: none;');

            if (self.hasItems()) {
                $("#emptyCartMessage").prop('style', 'display: none;');
            } else {
                $("#emptyCartMessage").prop('style', 'text-align: center; display: block;');
            }
        };

        self.getCart = function() {
            self.showLoadingGif();

            cartService.getCart().then(function(cart) {
                self.cart = cart;

                self.hideLoadingGif();

            });
        };

        self.hasItems = function() {
            return self.cart.items && self.cart.items.length > 0;
        };

        self.refreshCart = function() {
            var cache = $cacheFactory.get('$http');
            cache.removeAll();
            self.getCart();
        }

        self.getShipping = function() {
            $rootScope.$broadcast('cart.update');
        };

        self.removeShipping = function() {
            $rootScope.postalCode = '';
            $rootScope.$broadcast('cart.update');
        };

        $rootScope.$on('cart.update', function() {
            self.refreshCart();
        });

        self.getCart();

    }]);


angular.module('app')
    .controller('CartController', ['$rootScope', '$cacheFactory', 'CartService', function($rootScope, $cacheFactory, cartService) {

        var self = this;

        $rootScope.postalCode = '';

        self.cart = {};

        self.getCart = function() {
            cartService.getCart().then(function(cart) {
                self.cart = cart;
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


angular.module('app')
    .controller('CartWidgetController', ['CartService', '$rootScope', function(cartService, $rootScope) {

        var self = this;

        $rootScope.cart = {};

        self.getCart = function() {

            cartService.getCart().then(function(cart) {

                $rootScope.cart = cart;

            });

        };

        self.hasItems = function() {
            return $rootScope.cart.items && $rootScope.cart.items.length > 0;
        };

        self.getCart();

    }]);


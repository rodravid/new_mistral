angular.module('app')
    .controller('CartController', ['CartService', function(cartService) {

        var self = this;

        self.cart = {};

        self.getCart = function() {

            cartService.getCachedCart().then(function(cart) {

                self.cart = cart;

                self.getCart();

            });

        }

        self.hasItems = function() {
            return self.cart.items && self.cart.items.length > 0;
        }

        self.getCart();


    }]);


angular.module('app')
    .controller('CartController', ['CartService', function(cartService) {

        var self = this;

        self.cart = {};

        self.getCart = function() {

            cartService.getCart().then(function(cart) {

                self.cart = cart;

            });

        }

        self.hasItems = function() {
            return self.cart.items && self.cart.items.length > 0;
        }

        self.getCart();


    }]);


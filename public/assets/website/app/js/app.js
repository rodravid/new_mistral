var delay = (function(){

    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

angular.module('app', [])
    .run(['$rootScope', 'CartService', function($rootScope, cartService) {

        $rootScope.$on('cart.update', function() {
            cartService.getCart().then(function(cart) {
                $rootScope.cart = cart;
            });
        });

    }]);
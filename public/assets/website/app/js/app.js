var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

angular.module('app', [
    'Firestitch.angular-counter'
])
    .run(['$rootScope', 'CartService', function($rootScope, cartService) {

        $rootScope.$on('cart.item_added', function() {
            refreshCart();
        });

        $rootScope.$on('cart.item_removed', function() {
            refreshCart();
        });

        $rootScope.$on('cart.item_synced', function() {
            refreshCart();
        });

        $rootScope.$on('cart.update', function() {
            refreshCart();
        });

        function refreshCart() {
            cartService.getCart().then(function(cart) {
                $rootScope.cart = cart;
            });
        }

    }]);
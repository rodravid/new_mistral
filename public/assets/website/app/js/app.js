var delay = (function(){

    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };
})();

angular.module('app', [])
    .run(['$rootScope', '$cacheFactory', 'CartService', function($rootScope, $cacheFactory, cartService) {

        $rootScope.$on('cart.update', function() {

            var httpCache = $cacheFactory.get('$http');
            httpCache.removeAll();

            cartService.getCart().then(function(cart) {
                $rootScope.cart = cart;
            });
        });

    }]);
angular.module('app')
    .controller('CartController', ['$rootScope', '$scope', function($rootScope, $scope) {

        $rootScope.cart = {};

        $scope.getCart = function() {
            return $rootScope.cart;
        };

        $scope.hasItems = function() {
            return $rootScope.cart.items && $rootScope.cart.items.length > 0;
        };

        $scope.getCart();

    }]);


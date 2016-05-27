angular.module('app')
    .controller('CartController', ['$rootScope', '$scope', function($rootScope, $scope) {

        $rootScope.cart = {};

        $scope.postalCode = '';

        $scope.getCart = function() {
            return $rootScope.cart;
        };

        $scope.hasItems = function() {
            return $rootScope.cart.items && $rootScope.cart.items.length > 0;
        };

        $scope.getShipping = function() {

            console.log($scope.postalCode);

            //$rootScope.$broadcast('cart.update');
        };

        $scope.getCart();

    }]);


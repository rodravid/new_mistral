angular.module('app')
    .directive('cartItem', ['$rootScope', '$timeout', 'CartService', function($rootScope, $timeout, cartService) {

        return {

            link: function($scope, elt, attributes) {

                var $item = $(elt);
                var itemId = attributes.cartItem;

                $scope.removeItem = function() {

                    cartService.removeItem(itemId).then(function() {

                        $item.slideUp(300, function() {
                            $item.remove();
                        });

                        $rootScope.$broadcast('cart.item_removed');

                    }, function() {
                        swal('Ops!', response.data.message, 'error');
                    });

                };

                $scope.incrementQuantity = function() {

                    $scope.quantity++;

                    delay(function() {
                        syncQuantity(itemId, $scope.quantity);
                    }, 600);

                };

                $scope.decrementQuantity = function() {

                    $scope.quantity--;

                    if ($scope.quantity <= 0) {
                        $scope.quantity = 1;
                    }

                    delay(function() {
                        syncQuantity(itemId, $scope.quantity);
                    }, 600);
                };

                $scope.syncQuantity = function() {

                    if ($scope.quantity <= 0) {
                        $scope.quantity = 1;
                    }

                    syncQuantity(itemId, $scope.quantity);
                };

                function syncQuantity(id, quantity) {

                    cartService.syncQuantity(id, quantity).then(function() {

                        $rootScope.$broadcast('cart.item_synced');

                    }, function(response) {

                        swal('Ops!', response.data.message, 'error');

                        $rootScope.$broadcast('cart.item_synced');
                    });

                }

            }
        }

    }]);

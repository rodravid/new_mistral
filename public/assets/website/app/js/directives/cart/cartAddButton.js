angular.module('app')
    .directive('cartAddButton', ['$rootScope', 'CartService', function($rootScope, cartService) {

        return {

            restrict: 'A',

            scope: {
                variantId: '@',
                quantity: '@',
                quantityResolver: '&'
            },

            link: function($scope, elt, attributes) {

                var $item = $(elt);

                $item.bind('click', function() {

                    cartService.addItem($scope.variantId, getQuantity()).then(function(response) {

                        swal('Pronto!', response.message, 'success');

                        $rootScope.$broadcast('cart.update');

                    }, function(response) {

                        swal('Ops!', response.data.message, 'error');
                    });

                });

                function getQuantity() {

                    if (typeof $scope.quantity !== 'undefined') {
                        return $scope.quantity;
                    }

                    return $scope.quantityResolver();
                }

            }
        }

    }]);

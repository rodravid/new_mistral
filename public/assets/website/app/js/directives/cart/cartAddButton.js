angular.module('app')
    .directive('cartAddButton', ['$rootScope', 'CartService', function($rootScope, cartService) {

        return {

            restrict: 'A',

            scope: {
                variantId: '@',
                quantity: '@'
            },

            link: function($scope, elt, attributes) {

                var $item = $(elt);
                var variantId = attributes.variantId;
                var quantity = attributes.quantity;

                $item.bind('click', function() {

                    cartService.addItem(variantId, quantity).then(function(response) {

                        swal('Pronto!', response.message, 'success');

                        $rootScope.$broadcast('cart.update');

                    }, function(response) {

                        swal('Ops!', response.data.message, 'error');
                    });

                });


            }
        }

    }]);

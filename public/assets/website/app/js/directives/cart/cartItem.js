angular.module('app')
    .directive('cartItem', ['$rootScope', '$timeout', 'CartService', function($rootScope, $timeout, cartService) {

        return {

            scope: true,

            link: function($scope, elt, attributes) {

                var $item = $(elt);
                var itemId = attributes.cartItem;

                var $loadingContainer = $('#loading-container');
                var $loadingImg = $('<img src="/assets/website/images/loading.gif" alt="Carregando..." class="loading_gif">');

                function showLoading() {
                    $loadingContainer.html($loadingImg);
                }
                function hideLoading() {
                    $loadingContainer.html('');
                }

                $scope.removeItem = function() {

                    showLoading();

                    cartService.removeItem(itemId).then(function() {

                        $item.slideUp(300, function() {
                            $item.remove();
                        });

                        $rootScope.$broadcast('cart.update');

                    }, function() {
                        swal('Ops!', response.data.message, 'error');
                    });

                };

                $scope.incrementQuantity = function() {

                    showLoading();

                    $scope.quantity++;

                    delay(function() {
                        syncQuantity(itemId, $scope.quantity);
                    }, 600);

                };

                $scope.decrementQuantity = function() {

                    $scope.quantity--;

                    if ($scope.quantity <= 0) {
                        $scope.quantity = 1;
                        return;
                    }

                    showLoading();

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

                        $rootScope.$broadcast('cart.update');

                    }, function(response) {

                        swal('Ops!', response.data.message, 'error');

                        $rootScope.$broadcast('cart.update');
                    });

                }

            }
        }

    }]);

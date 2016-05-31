angular.module('app')
    .controller('HomeController', ['$scope', '$rootScope', '$http', function($scope, $rootScope, $http) {


        $scope.comprar = function(variant, quantity) {

            $http.post('/carrinho/add', {
                variant: variant,
                quantity: quantity
            }).then(function(response) {

                swal('Pronto', response.data.message, 'success');

                $rootScope.$broadcast('cart.item_added');

            });


        };

    }]);

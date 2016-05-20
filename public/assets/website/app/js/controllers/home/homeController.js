angular.module('app')
    .controller('HomeController', ['$scope', '$http', function($scope, $http) {


        $scope.comprar = function(variant, quantity) {

            $http.post('/carrinho/add', {
                variant: variant,
                quantity: quantity
            }).then(function() {

                alert('Adicionado');

            });


        };

    }]);

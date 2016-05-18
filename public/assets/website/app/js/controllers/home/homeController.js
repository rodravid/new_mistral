angular.module('app')
    .controller('HomeController', ['$scope', '$http', function($scope, $http) {


        $scope.comprar = function() {

            $http.post('/carrinho/add', function() {

                alert('Adicionado');

            });


        };

    }]);

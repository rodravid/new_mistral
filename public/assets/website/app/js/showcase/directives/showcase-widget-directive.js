angular.module('app')
    .directive('showcaseWidget', ['$http', '$compile', function($http, $compile) {

        return {

            restrict: 'AE',

            scope: {
                showcaseId: '@',
                currentPage: '@?',
                loadFirst: '='
            },

            require: '^showcaseContainer',

            link: function($scope, $el, $attributes, $controller) {

                if(typeof $scope.currentPage === 'undefined') {
                    $scope.currentPage = 1;
                }

                var self = this;

                $controller.registerShowcaseWidget($el, $scope);


                if ($scope.loadFirst) {

                    loadProducts();

                }

                function loadProducts() {

                    $http({
                        method: 'GET',
                        url: '/api/showcase/' + $scope.showcaseId + '/products?page=' + $scope.currentPage,
                        responseType: 'html'
                    }).then(function(response) {

                        $($el).find('.container-products').append($compile(response.data)($scope));

                    });

                };

            }
        }

    }]);
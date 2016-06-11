angular.module('app')
    .directive('showcaseWidget', ['$http', '$compile', function($http, $compile) {

        return {

            restrict: 'AE',

            scope: {
                showcaseId: '@',
                currentPage: '@?',
                limit: '@?',
                loadFirst: '='
            },

            require: '^showcaseContainer',

            link: function($scope, $el, $attributes, $controller) {

                if(typeof $scope.currentPage === 'undefined') {
                    $scope.currentPage = 1;
                }

                if(typeof $scope.limit === 'undefined') {
                    $scope.limit = 1;
                }

                var self = this;

                $controller.registerShowcaseWidget($el, $scope);


                if ($scope.loadFirst) {

                    loadProducts();

                }
                
                $($el).find('.loadProducts').bind('click', function() {

                    loadProducts();

                });

                $scope.loadProducts = function() {
                    loadProducts();
                };

                function loadProducts() {

                    $http({
                        method: 'GET',
                        url: '/api/showcase/' + $scope.showcaseId + '/products?page=' + $scope.currentPage + '&limit=' + $scope.limit,
                        responseType: 'html'
                    }).then(function(response) {

                        var $html = $($compile(response.data)($scope));

                        $html.hide().appendTo($($el).find('.container-products')).fadeIn();

                        $scope.currentPage++;

                        //$($el).find('.container-products').append($compile(response.data)($scope));

                    });

                }

            }
        }

    }]);
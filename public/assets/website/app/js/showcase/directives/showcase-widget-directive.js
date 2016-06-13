angular.module('app')
    .directive('showcaseWidget', ['$http', '$compile', function($http, $compile) {

        return {

            restrict: 'AE',

            scope: {
                showcaseId: '@',
                currentPage: '@?',
                limit: '@?',
                initialLimit: '@?',
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

                if(typeof $scope.initialLimit === 'undefined') {
                    $scope.initialLimit = 3;
                }

                $controller.registerShowcaseWidget($el, $scope);

                if ($scope.loadFirst) {
                    loadProducts($scope.showcaseId, $scope.currentPage, $scope.initialLimit);

                    $scope.currentPage = $scope.initialLimit;
                }
                
                $($el).find('.loadProducts').bind('click', function() {
                    loadProducts($scope.showcaseId, $scope.currentPage, $scope.limit);
                });

                $scope.loadProducts = function() {
                    loadProducts($scope.showcaseId, $scope.currentPage, $scope.limit);
                };

                function loadProducts(showcase, page, limit) {

                    $http({
                        method: 'GET',
                        url: '/api/showcase/' + showcase + '/products?page=' + page + '&limit=' + limit,
                        responseType: 'html'
                    }).then(function(response) {

                        if (response.data != '') {

                            var $html = $($compile(response.data)($scope));

                            $html.hide().appendTo($($el).find('.container-products')).fadeIn();

                            $scope.currentPage++;

                        } else {

                            $('body').find('#btnShowcaseLoadMore').fadeOut();

                        }

                    });

                }

            }
        }

    }]);
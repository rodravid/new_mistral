angular.module('app')
    .directive('favoriteWidget', ['$timeout', '$window', 'FavoriteService', function($timeout, $window, favoriteService) {

        var $modalLogin = $('.modal-login');
        var $overlay = $('.overlay');

        return {

            restrict: 'AE',

            template: '<span class="favorite" ng-class="getFavoriteClass()" ng-click="favorite()"></span>',

            scope: {
                product: '@',
                favorited: '@?',
                favoritedClass: '@?'
            },

            link: function($scope) {

                $scope.favorite = function() {

                    toggleFavorite();

                    favorite();
                };

                $scope.getFavoriteClass = function() {

                    if ($scope.favorited) {
                        return $scope.favoritedClass ? $scope.favoritedClass : 'clicado';
                    }

                    return '';
                };

                function toggleFavorite() {
                    $scope.favorited = ! $scope.favorited;
                }

                function favorite(callback) {

                    favoriteService.toggle($scope.product, $scope.favorited).then(function(response) {

                        //swal('Pronto!', response.message, 'success');

                        if (callback) {
                            callback();
                        }

                    }, function(response) {

                        if (response.status === 401) {

                            $modalLogin.data('callback', function() {

                                favorite(function() {

                                    $window.location.reload();

                                });

                            }).fadeIn();
                            $overlay.fadeIn();
                        } else {

                            swal('Ops!', response.data.message, 'error');

                        }

                    });

                }

            }
        }

    }]);

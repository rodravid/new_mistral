angular.module('app')
    .directive('favoriteWidget', [function() {

        return {

            restrict: 'AE',

            template: '<span class="favorite" ng-click="favorite()"></span>',

            scope: {
                item: '@',
            },

            link: function($scope, $elt, $attributes) {

                $scope.favorite = function() {


                };

            }
        }

    }]);

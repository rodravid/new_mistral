angular.module('app')
    .directive('showcaseContainer', [function() {

        return {

            restrict: 'A',

            scope: true,

            controller: ['$scope', function($scope) {

                var self = this;

                self.widgets = [];

                self.registerShowcaseWidget = function (el, scope) {
                    self.widgets.push({
                        el:el,
                        scope:scope
                    });
                }

            }]
        }

    }]);

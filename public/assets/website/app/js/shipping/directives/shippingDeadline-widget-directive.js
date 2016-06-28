angular.module('app')
    .directive('shippingDeadlineWidget', ['ShippingDeadlineService', '$rootScope', function(deadlineService, $rootScope) {

        return {

            restrict: 'A',

            scope: true,

            link: function($scope, $elements, $attributes) {

                $scope.submitForm = function(e) {
                    e.preventDefault();

                    deadlineService.create($scope.cep, $rootScope.itemQuantity, $rootScope.boxQuantity, $scope.product).then(
                        function (response) {
                            $scope.cep = "";

                            $($elements).find('input.error-field').removeClass('error-field');

                            $($elements).find('p.answer-delivery').html(response);
                        },
                        function (response) {
                            $($elements).find('p.answer-delivery').html(response.message);
                        }
                    );
                };
            }
        }

    }]);
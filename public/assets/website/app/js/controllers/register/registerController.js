angular.module('app')
    .controller('RegisterController', ['$scope', function($scope) {

        $scope.onCustomerTypeChange = function() {

            if ($scope.customerType == 1) {
                $scope.addressType = 1;

            } else if ($scope.customerType == 2) {
                $scope.addressType = 2;
            }

        };

        $scope.onCustomerTypeChange();

    }]);

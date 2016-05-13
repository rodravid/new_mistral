angular.module('app')
    .controller('LoginCtrl', ['$scope', 'AuthService', function($scope, auth) {

        $scope.email = '';
        $scope.password = '';

        $scope.postLogin = function(e) {

            var email = $scope.email;
            var password = $scope.password;

            auth.login(email, password).then(handleLoginSuccess, handleLoginError);

            e.preventDefault();
        };

        function handleLoginSuccess(response)
        {
            console.log(response);
        }

        function handleLoginError(response)
        {

            alert('Não foi possicel fazer o login');

        }

    }]);
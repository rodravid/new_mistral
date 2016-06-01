angular.module('app')
    .controller('ModalLoginCtrl', ['$scope', '$window', 'AuthService', function($scope, $window, auth) {

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
            if (response.url) {
                $window.location.href = response.url;
            }
        }

        function handleLoginError(response)
        {
            if (response.data.email || response.data.password) {

                $.each(response.data, function(field, messages) {

                    var $field = $('input[name=' + field + ']');

                    $field.addClass('error-field');

                    $field.parent('li').find('label').text(messages[0]).fadeIn();

                });

            } else {

                if (response.data.message) {

                    $('.modal-login').find('.box-error').text(response.data.message).fadeIn();
                }

            }
        }

    }]);
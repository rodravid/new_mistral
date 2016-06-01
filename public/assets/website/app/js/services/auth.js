angular.module('app')
    .factory('AuthService', ['$http', '$q', function($http, $q) {

        return ({
            login: login,
            resetPassword: resetPassword
        });

        function login(email, password) {

            var request = $http({
                method: "post",
                url: "/login",
                data: {
                    email: email,
                    password: password
                }
            });

            return(request.then(handleSuccess, handleError));
        }

        function resetPassword(email)
        {
            var request = $http({
                method: "post",
                url: "/password/email",
                data: {
                    email: email
                }
            });

            return(request.then(handleSuccess, handleError));
        }

        function handleError(response) {
            if (
                ! angular.isObject( response.data )
            ) {
                return( $q.reject("An unknown error occurred."));
            }

            return( $q.reject(response));
        }

        function handleSuccess( response ) {
            return( response.data );
        }

    }]);

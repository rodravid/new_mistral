angular.module('app')
    .factory('NewsletterService', ['$http', '$q', function($http, $q) {

        return ({
            create: create
        });

        function create(name, email) {

            var request = $http({
                method: "post",
                url: "/login",
                data: {
                    name: name,
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

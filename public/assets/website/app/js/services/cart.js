angular.module('app')
    .factory('CartService', ['$http', '$q', function($http, $q) {

        return ({
            getCart: getCart
        });

        function getCart() {

            var request = $http({
                method: "get",
                url: "/carrinho/items"
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

        function handleSuccess(response) {

            return(response.data);
        }

    }]);

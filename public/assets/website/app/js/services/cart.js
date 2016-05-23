angular.module('app')
    .factory('CartService', ['$http', '$q', function($http, $q) {

        return ({
            getCart: getCart,
            removeItem: removeItem,
            syncQuantity: syncQuantity
        });

        function getCart() {

            var request = $http({
                method: "get",
                url: "/carrinho/items"
            });

            return(request.then(handleSuccess, handleError));
        }

        function removeItem(id) {

            var request = $http({
                method: "delete",
                url: "/carrinho/items/" + id + "/remove"
            });

            return(request.then(handleSuccess, handleError));
        }

        function syncQuantity(id, quantity) {

            var request = $http({
                method: "post",
                url: "/carrinho/items/" + id + "/sync",
                data: {quantity: quantity}
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

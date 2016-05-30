angular.module('app')
    .factory('CartService', ['$http', '$q', '$rootScope', function($http, $q, $rootScope) {

        return ({
            getCart: getCart,
            addItem: addItem,
            removeItem: removeItem,
            syncQuantity: syncQuantity
        });

        function getCart() {

            var url = '/carrinho/items';

            if (typeof $rootScope.postalCode !== 'undefined' && $rootScope.postalCode !== '') {
                url += "?postal_code=" + $rootScope.postalCode;
            }

            var request = $http({
                method: "get",
                url: url,
                cache: true
            });

            return(request.then(handleSuccess, handleError));
        }

        function addItem(variant, quantity) {

            var request = $http.post('/carrinho/items/add', {
                variant: variant,
                quantity: quantity
            });

            return request.then(handleSuccess, handleError);
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

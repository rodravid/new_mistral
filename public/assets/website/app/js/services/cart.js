angular.module('app')
    .factory('CartService', ['$http', '$q', '$cacheFactory', function($http, $q, $cacheFactory) {

        var cache = $cacheFactory('myCache');
        var cachedCart = {};

        return ({
            getCart: getCart,
            getCachedCart: getCachedCart
        });

        function getCart() {

            var request = $http({
                method: "get",
                url: "/carrinho/items"
            });

            return(request.then(handleSuccess, handleError));
        }

        function getCachedCart()
        {
            if (! cache.get('cart')) {

                console.log(cachedCart);
                return getCart();
            }

            return $q.defer(cache.get('cart')).promise;
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

            cache.put('cart', response.data);

            return(response.data);
        }

    }])

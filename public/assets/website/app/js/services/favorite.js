angular.module('app')
    .factory('FavoriteService', ['$http', '$q', function($http, $q) {

        return ({
            toggle: toggle,
        });

        function toggle(product, toggle) {

            var request = $http({
                method: "post",
                url: "/api/product/" + product + '/favorite',
                data: {
                    toggle: toggle
                }
            });

            return(request.then(handleSuccess, handleError));
        }

        function handleError(response) {
            return($q.reject(response));
        }

        function handleSuccess(response) {
            return(response.data);
        }

    }]);

angular.module('app')
    .factory('ShippingDeadlineService', ['$http', '$q', function($http, $q) {

        return ({
            create: create
        });

        function create(cep, itemQuantity, boxQuantity, product) {

            var request = $http({
                method: "post",
                url: "/api/shippingDeadline/calculate",
                data: {
                    cep: cep,
                    itemQuantity: itemQuantity,
                    boxQuantity: boxQuantity,
                    product: product
                }
            });

            return(request.then(handleSuccess, handleError));
        }

        function handleError(response) {

            $('input[name=shippingDeadline_cep]').addClass('error-field');

            return( $q.reject(response.data) );
        }

        function handleSuccess( response ) {
            return( response.data );
        }

    }]);
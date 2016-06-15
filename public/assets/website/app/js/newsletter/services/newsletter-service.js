angular.module('app')
    .factory('NewsletterService', ['$http', '$q', function($http, $q) {

        return ({
            create: create
        });

        function create(name, email) {

            var request = $http({
                method: "post",
                url: "/api/newsletter/register",
                data: {
                    name: name,
                    email: email
                }
            });

            return(request.then(handleSuccess, handleError));
        }

        function handleError(response) {
            if (response.data.email || response.data.name) {

                $.each(response.data, function(field, messages) {

                    var $field = $('input[name=' + field + ']');

                    $field.addClass('error-field');

                    $field.parent('li').find('label').text(messages[0]).fadeIn();

                });

            }

            return( $q.reject(response.data) );
        }

        function handleSuccess( response ) {
            return( response.data );
        }

    }]);

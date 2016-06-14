angular.module('app')
    .directive('newsletterWidget', ['NewsletterService', function(newsService) {

        return {

            restrict: 'A',

            scope: true,

            link: function($scope, $elements, $attributes) {

                $scope.submitForm = function(e) {

                    newsService.create($scope.name, $scope.email).then(
                        function (response) {
                            $scope.name = "";
                            $scope.email = "";

                            $($elements).find('input.error-field').removeClass('error-field');

                            swal('Cadastrado!', response.message, 'success');
                        },
                        function (response) {
                            var errorMessage = "Os seguinte erros foram encontrados: \n\n";

                            $.each(response.data, function (field, message) {
                                var $field = $('input[name=newsletter_' + field + ']');

                                $field.addClass('error-field');

                                errorMessage += message + " \n";
                            });

                            swal('Falha no cadastro.', errorMessage, 'error');
                        }
                    );

                    e.preventDefault();
                };

            }
        }

    }]);
angular.module('app')
    .directive('newsletterWidget', ['NewsletterService', function(newsService) {

        return {

            restrict: 'A',

            scope: true,

            link: function($scope, $el, $attributes) {

                $scope.submitForm = function(e) {

                    newsService.create('email', 'password');

                    e.preventDefault();
                };

            }
        }

    }]);

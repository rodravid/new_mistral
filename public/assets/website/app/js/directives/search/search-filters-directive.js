angular.module('app')
    .directive('searchFilters', ['$timeout', '$window', function($timeout, $window) {

        return {

            restrict: 'A',

            scope: true,

            link: function($scope, el) {

                var $el = $(el);

                $el.find('.search-filter-value').bind('click', function() {

                    var $self = $(this);
                    var urlKey = $self.parent('.search-filter').data('urlkey');
                    var value = $self.data('value');

                    var uri = getUri();

                    uri.addSearch(urlKey, value);

                    $window.location.href = uri;

                });

                $el.find('.remove-filter').bind('click', function() {

                    var $self = $(this);
                    var urlKey = $self.data('urlkey');
                    var value = $self.data('value');

                    var uri = getUri();

                    uri.removeSearch(urlKey, value);

                    $window.location.href = uri;

                });

                $('body').find('.changeLimit').bind('change', function() {

                    var $self = $(this);
                    var limit = $self.val();
                    
                    var uri = getUri();

                    uri.removeSearch('page');
                    uri.setSearch('max', limit);

                    $window.location.href = uri;

                });

                $('body').find('.changeOrder').bind('change', function() {

                    var $self = $(this);
                    var order = $self.val();

                    var uri = getUri();

                    uri.setSearch('ordem', order);

                    $window.location.href = uri;

                });

                function getUri() {
                    return new URI($window.location.href);
                }
                
                function parseUrlKey(key) {
                    var regex = /\[[0-9]+\]/;

                    return key.replace(regex, '[]');
                }

            }
        }

    }]);

angular.module('app')
    .directive('searchSuggestion', [function() {

        return {

            restrict: 'A',

            scope: true,

            link: function($scope, el) {

                var $el = $(el);


                $el.find('input[type="text"]').typeahead({

                    dynamic: true,

                    resultContainer: '#suggestion-result',

                    source: {
                        products: {
                            display: ["title", "country", "producer", 'url'],
                            ajax: {
                                url: '/api/search/suggest',
                                data: {
                                    q: '{{query}}'
                                }
                            },
                            template: function(query, item) {

                                return '<a href="{{url|raw}}" class="suggestions-link">' +
                                    '{{title|raw}}' +
                                    '<p>{{producer|raw}} / {{country|raw}}</p>' +
                                    '</a>';
                            }
                        }
                    },

                    selector: {
                        result: 'results-suggestions',
                        list: 'suggestions-list'
                    }

                });

            }
        }

    }]);

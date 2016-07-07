angular.module('app')
    .controller('CartController', ['$rootScope', '$cacheFactory', 'CartService', function($rootScope, $cacheFactory, cartService) {

        var self = this;
        var $loadingContainer = $('#loading-container');
        var $loadingImg = $('<img src="/assets/website/images/loading.gif" alt="Carregando..." class="loading_gif">');

        function showLoading() {
            $loadingContainer.html($loadingImg);
        }
        function hideLoading() {
            $loadingContainer.html('');
        }

        $rootScope.postalCode = '';

        self.cart = {};

        self.showLoadingGif = function() {
           showLoading();
        };

        self.hideLoadingGif = function() {
            hideLoading();

            if (self.hasItems()) {
                $("#emptyCartMessage").prop('style', 'display: none;');
            } else {
                $("#emptyCartMessage").prop('style', 'text-align: center; display: block;');
            }
        };

        self.getCart = function() {
            self.showLoadingGif();

            cartService.getCart().then(function(cart) {
                self.cart = cart;

                self.hideLoadingGif();

            });
        };

        self.hasItems = function() {
            return self.cart.items && self.cart.items.length > 0;
        };

        self.isInvalid = function() {
            return self.hasItems() && self.cart.valid_items_count == 0;
        }

        self.refreshCart = function() {
            var cache = $cacheFactory.get('$http');
            cache.removeAll();
            self.getCart();
        }

        self.getShipping = function() {
            $rootScope.$broadcast('cart.update');
        };

        self.removeShipping = function() {
            $rootScope.postalCode = '';
            $rootScope.$broadcast('cart.update');
        };

        $rootScope.$on('cart.update', function() {
            self.refreshCart();
        });

        self.getCart();

    }]);


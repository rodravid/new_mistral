angular.module('app')
    .controller('ProductPageController', ['$scope','$rootScope', function($scope, $rootScope) {

        var self = this;

        self.boxQuantityFactor = 1;
        $rootScope.boxQuantity = 0;
        $rootScope.itemQuantity = 1;

        self.getQuantityForCart = function () {
            if (typeof self.boxQuantity !== 'undefined') {

                return self.itemQuantity + (self.boxQuantity * self.boxQuantityFactor);
            }

            return self.itemQuantity;

        };

        self.incrementItemQuantity = function() {
            self.itemQuantity++;

            $rootScope.itemQuantity = self.itemQuantity;
        };

        self.decrementItemQuantity = function() {
            self.itemQuantity--;
            if (self.itemQuantity <= 0) {
                self.itemQuantity = 1;
            }

            $rootScope.itemQuantity = self.itemQuantity;
        };

        self.updateQuantity = function() {
            if (isNaN(parseInt(self.itemQuantity))) {
                self.itemQuantity = 1;
                return;
            }
            if (self.itemQuantity <= 0) {
                self.itemQuantity = 1;
                return;
            }
            self.itemQuantity = parseInt(self.itemQuantity);
        };

        self.incrementBoxQuantity = function() {
            self.boxQuantity++;

            $rootScope.boxQuantity = self.boxQuantity;
        };

        self.decrementBoxQuantity = function() {
            self.boxQuantity--;
            if (self.boxQuantity < 0) {
                self.boxQuantity = 0;
            }

            $rootScope.boxQuantity = self.boxQuantity;
        };

        self.updateQuantity = function() {
            if (isNaN(parseInt(self.boxQuantity))) {
                self.boxQuantity = 0;
                return;
            }
            if (self.boxQuantity < 0) {
                self.boxQuantity = 0;
                return;
            }
            self.boxQuantity = parseInt(self.boxQuantity);
        };

    }]);

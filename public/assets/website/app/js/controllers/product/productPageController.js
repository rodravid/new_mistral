angular.module('app')
    .controller('ProductPageController', ['$scope', function($scope) {

        var self = this;

        self.boxQuantityFactor = 1;

        self.getQuantityForCart = function () {
            return self.itemQuantity + (self.boxQuantity * self.boxQuantityFactor);
        };

        self.incrementItemQuantity = function() {
            self.itemQuantity++;
        };

        self.decrementItemQuantity = function() {
            self.itemQuantity--;
            if (self.itemQuantity <= 0) {
                self.itemQuantity = 1;
            }
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
        };

        self.decrementBoxQuantity = function() {
            self.boxQuantity--;
            if (self.boxQuantity < 0) {
                self.boxQuantity = 0;
            }
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

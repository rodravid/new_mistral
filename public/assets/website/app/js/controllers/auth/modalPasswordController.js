angular.module('app')
    .controller('ModalPasswordCtrl', ['$scope', '$window', 'AuthService', function($scope, $window, auth) {

        $scope.email = '';

        $scope.postReset = function(e) {

            var email = $scope.email;

            auth.resetPassword(email).then(handleResetSuccess, handleResetError);

            e.preventDefault();
        };

        function handleResetSuccess(response)
        {

            $scope.email = '';

            $('.modal-recovery').find('.error-field').removeClass('error-field');
            $('.modal-recovery').find('.box-error').hide();

            $('.overlay, .modal-login, .modal-recovery, .modal-adress, .global-modal, .modal-delivery-time, .modal-gift').fadeOut(300, function() {
                swal('Pronto!', response.message, 'success');
            });

        }

        function handleResetError(response)
        {
            if (response.data.email) {

                $.each(response.data, function(field, messages) {

                    var $field = $('input[name=' + field + ']');

                    $field.addClass('error-field');

                    $('.modal-recovery').find('.box-error').text(messages[0]).fadeIn();

                });

            } else {
                $('.modal-recovery').find('.box-error').text(response.data.message);
            }
        }

    }]);
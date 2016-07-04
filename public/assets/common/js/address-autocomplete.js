(function($) {

    $.each($('select[data-state]'), function(i, select) {

        var $selectState = $(select);
        var $selectCity = $($selectState.data('target'));

        $selectState.bind('change', function() {

            var $self = $(this);
            var state = $self.val();
            var optionDefault = '<option value="">Cidade</option>';

            if (state == '') {

                setOptions($selectCity, optionDefault);
                return;
            }

            setOptions($selectCity, '<option value="">Carregando...</option>');

            getCitiesByState(state, function(cities) {

                var options = optionDefault;

                $.each(cities, function(i, city) {
                    options += '<option value="' + city.id + '">' + city.name + '</option>';
                });

                setOptions($selectCity, options);

                var selectedId = $selectCity.data('value');

                $selectCity.find('option[value="' + selectedId + '"]').prop('selected', true).trigger('change');

            });

        }).change();

        function setOptions(select, options) {
            select.html(options).trigger('change');
        }

        function getCitiesByState(state, callback)
        {
            $.get('/api/ibge/cities/' + state, function(cities) {
                callback(cities);
            });
        }

    });

    $.each($('input[data-postalcode]'), function(i, input) {

        var $input = $(input);

        $input.bind('focusout', function() {

            var postalCode = $input.val();
            var $selectPublicPlace = $($input.data('target-publicplace'));
            var $txtAddress = $($input.data('target-address'));
            var $txtDistrict = $($input.data('target-district'));
            var $txtNumber = $($input.data('target-number'));
            var $txtComplement = $($input.data('target-complement'));
            var $selectState = $($input.data('target-state'));
            var $selectCity = $($input.data('target-city'));

            getAddressInfo(postalCode, function(addressInfo) {

                var stateIbgeCode = addressInfo.estado_info.codigo_ibge;
                var cityIbgeCode = addressInfo.cidade_info.codigo_ibge;

                $selectState.find('option[value="' + stateIbgeCode + '"]').prop('selected', true);
                $selectCity.data('value', cityIbgeCode);

                $selectState.trigger('change');

                if (typeof addressInfo.logradouro !== 'undefined') {
                    var addressPublicPlace = addressInfo.logradouro.split(" ")[0];

                    var inputPublicPlace = $selectPublicPlace.find('option').filter(function () {
                        return $(this).text().trim() == addressPublicPlace;
                    });

                    if (inputPublicPlace.length) {
                        inputPublicPlace.prop('selected', true);
                        addressInfo.logradouro = addressInfo.logradouro.replace(addressPublicPlace, "");
                    } else {
                        $selectPublicPlace.find('option').filter(function () {
                            return $(this).text().trim() == "Outro";
                        }).prop('selected', true);
                    }

                    $txtAddress.val(addressInfo.logradouro);
                } else {
                    $selectPublicPlace.find('option').filter(function () {
                        return $(this).text().trim() == "Outro";
                    }).prop('selected', true);

                    $txtAddress.val('');
                }

                if (typeof addressInfo.bairro !== 'undefined') {
                    $txtDistrict.val(addressInfo.bairro);
                } else {
                    $txtDistrict.val('');
                }

                $txtNumber.val('');
                $txtComplement.val('');
            });

        });

    });

    function getAddressInfo(postalCode, callback)
    {
        $.get('http://api.postmon.com.br/v1/cep/' + postalCode, function(response) {
            callback(response);
        });
    }

})($);
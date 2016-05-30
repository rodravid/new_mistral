<?php
    $address = new \Vinci\Domain\Customer\Address\Address();
    $r = new ReflectionObject($address);
    $property = $r->getProperty('id');
    $property->setAccessible(true);
    $property->setValue($address, 0);
?>
<div class="col-xs-12 address-box" data-id="{{ $address->getId() }}">
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><i class="fa fa-flag-checkered"></i> Novo endereço</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            @include('cms::customers.partials.address.form')
            <div class="col-lg-6">
                <div class="radio">
                    <label for="radionMainAddress{{ $address->getId() }}">
                        <input type="radio" name="main_address" value="0" id="radionMainAddress{{ $address->getId() }}" @if(old('main_address', 0) == '0') checked @endif>
                        Endereço principal
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

namespace Vinci\Domain\ERP\Product;

interface ProductFactory
{

    public function makeFromXmlObject($xmlObject);

    public function makeListFromXmlObject($xmlObject, $field = 'COD_PRODUTO');

}
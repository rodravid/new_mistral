<?php

namespace Vinci\Domain\ERP\Product;

interface ProductFactory
{

    public function makeFromXmlObject($xmlObject);

}
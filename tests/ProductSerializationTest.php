<?php

class ProductSerializationTest extends TestCase
{

    public function testSearializeAnProduct()
    {

        $product = app(\Vinci\Domain\Country\CountryRepository::class)->find(2);
        

        $serialized = serialize($product);

        $teste = unserialize($serialized);

        $teste->setName('África do Sullll');

        app('em')->persist($teste);

        app('em')->flush();

    }
}

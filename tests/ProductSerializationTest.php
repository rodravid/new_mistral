<?php

class ProductSerializationTest extends TestCase
{

    public function testSearializeAnProduct()
    {

        $product = app(\Vinci\Domain\Product\Repositories\ProductRepository::class)->find(1);

        $serialized = serialize($product);

        dd($serialized);

    }
}

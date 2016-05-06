<?php

namespace Vinci\App\Cms\Http;

use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Pricing\Calculator\StandardPriceCalculator;
use Vinci\Domain\Product\ProductVariant;
use Vinci\Domain\Product\ProductVariantPrice;
use Vinci\Domain\Product\Wine\Wine;
use Vinci\Domain\Product\Wine\WineVariant;

class TestController extends Controller
{

    public function index()
    {

        $channel1 = new Channel();
        $channel1->setName('Default');
        $channel1->setCode(Channel::DEFAULT_CHANNEL);

        $channel2 = new Channel();
        $channel2->setName('Teste');
        $channel2->setCode('teste');

        $price1 = new ProductVariantPrice();
        $price1->setPrice('2.99');

        $price2 = new ProductVariantPrice();
        $price2
            ->setPrice('5.80')
            ->setChannel($channel2);

        $wine = new Wine();
        $variant = new ProductVariant();

        $wine->setMasterVariant($variant)
             ->addChannel($channel1);

        $wine->setTitle('Teste')
            ->setDescription('testando')
            ->addPrice($price1)
            ->addPrice($price2)
        ;

        $wine->setPriceCalculator(new StandardPriceCalculator());

        $wine->setCurrentChannel($channel1);

        dd($wine->getPrice()->asSalePrice());

    }

}
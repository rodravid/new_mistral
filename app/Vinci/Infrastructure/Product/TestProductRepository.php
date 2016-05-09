<?php

namespace Vinci\Infrastructure\Product;

use Illuminate\Contracts\Events\Dispatcher;
use Vinci\Domain\Product\Events\ProductWasLoaded;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Product\ProductVariant;
use Vinci\Domain\Product\ProductVariantPrice;
use Vinci\Domain\Product\Wine\Wine;

class TestProductRepository implements ProductRepository
{

    protected $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function find($id)
    {
        $channel1 = new Channel();
        $channel1->setName('Default');
        $channel1->setCode(Channel::DEFAULT_CHANNEL);

        $channel2 = new Channel();
        $channel2->setName('Teste');
        $channel2->setCode('teste');

        $channel3 = new Channel();
        $channel3->setName('Outro');
        $channel3->setCode('outro');

        $price1 = new ProductVariantPrice();
        $price1->setPrice(2.99)
            ->setChannel($channel1);

        $price2 = new ProductVariantPrice();
        $price2->setPrice(5.80)
            ->setChannel($channel2);

        $price3 = new ProductVariantPrice();
        $price3->setPrice(15.95)
            ->setChannel($channel3);

        $wine = new Wine();
        $variant = new ProductVariant();

        $wine->setMasterVariant($variant)
            ->addChannel($channel1)
            ->addChannel($channel2)
            ->addChannel($channel3);

        $wine->setTitle('Teste')
            ->setDescription('testando')
            ->addPrice($price1)
            ->addPrice($price2)
            ->addPrice($price3)
        ;

        $wine->setCurrentChannel('outro');

        $this->fireLoadEvent($wine);

        return $wine;
    }

    protected function fireLoadEvent($product)
    {
        if ($product instanceof ProductInterface) {
            $this->dispatcher->fire(new ProductWasLoaded($product));
            return true;
        }

        if (is_array($product)) {
            foreach ($product as $p) {
                $this->fireLoadEvent($p);
            }
        }
    }

}
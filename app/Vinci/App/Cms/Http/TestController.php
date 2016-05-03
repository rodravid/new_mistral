<?php

namespace Vinci\App\Cms\Http;

use Vinci\Domain\Product\Wine\Wine;
use Vinci\Domain\Product\Wine\WineVariant;

class TestController extends Controller
{

    public function index()
    {

        $wine = new Wine();
        $wineVariant = new WineVariant();
        $wine->setMasterVariant($wineVariant);

        $wine->setTitle('Teste')
            ->setDescription('testando')
            ->setPrice(50.99)
        ;

        $this->entityManager->persist($wine);
        $this->entityManager->flush();
    }

}
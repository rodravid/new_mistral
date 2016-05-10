<?php

namespace Vinci\App\Cms\Http;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Product\Repositories\ProductRepository;

class TestController extends Controller
{

    private $productRepository;

    public function __construct(EntityManagerInterface $em, ProductRepository $productRepository)
    {
        parent::__construct($em);

        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $product = $this->productRepository->find(1);

        //$product->setCurrentChannel('teste');

        dd('Produto ' . $product->getTitle() . ': R$ ' . number_format($product->getPrice()->asSalePrice(), 2, ',', '.'));
    }

}
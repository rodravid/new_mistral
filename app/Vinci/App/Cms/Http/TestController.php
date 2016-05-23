<?php

namespace Vinci\App\Cms\Http;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\ShoppingCart\ShoppingCart;

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
//        $product = $this->productRepository->find(1);
//
//        //$product->setCurrentChannel('teste');
//
//        dd('Produto ' . $product->getTitle() . ': R$ ' . number_format($product->getPrice()->asSalePrice(), 2, ',', '.'));



       $cart = $this->entityManager->getRepository(ShoppingCart::class)->find('7a5485e3-c35a-49db-bdd1-9da4ce9c19c4');


        $cart = new ShoppingCart();


        dd($cart->getId() == '7a5485e3-c35a-49db-bdd1-9da4ce9c19c4');

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

    }

}
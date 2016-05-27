<?php

namespace Vinci\App\Website\Http\Product;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;

class ProductController extends Controller
{
    protected $customerService;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function index()
    {
        return $this->view('product.index');
    }

}
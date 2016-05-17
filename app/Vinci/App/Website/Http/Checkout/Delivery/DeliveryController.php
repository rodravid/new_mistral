<?php

namespace Vinci\App\Website\Http\Checkout\Delivery;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;

class DeliveryController extends Controller
{
    protected $customerService;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function index()
    {
        return $this->view('checkout.delivery.index');
    }

}
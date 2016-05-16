<?php

namespace Vinci\App\Website\Http\Checkout\Payment;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;

class PaymentController extends Controller
{
    protected $customerService;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);
    }

    public function index()
    {
        return $this->view('checkout.payment.index');
    }

}
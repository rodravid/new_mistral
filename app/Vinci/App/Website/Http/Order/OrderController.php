<?php

namespace Vinci\App\Website\Http\Order;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Controller;

class OrderController extends Controller
{

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

    }

    public function store(Request $request)
    {

        dd($request->all());

    }

}
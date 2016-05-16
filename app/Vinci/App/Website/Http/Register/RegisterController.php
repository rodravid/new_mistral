<?php

namespace Vinci\App\Website\Http\Register;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Customer\CustomerService;

class RegisterController extends Controller
{
    protected $customerService;

    public function __construct(EntityManagerInterface $em, CustomerService $customerService)
    {
        parent::__construct($em);
        $this->customerService = $customerService;
    }

    public function index()
    {
        return $this->view('register.index');
    }

    public function store(Request $request)
    {

        dd($request->all());

    }

}
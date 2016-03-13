<?php

namespace Vinci\App\Website\Http\Home;

use Carbon\Carbon;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Customer\CustomerRepository;

class HomeController extends Controller
{

    public function index(CustomerRepository $repo)
    {

        $customer = new Customer;

        $customer->setName('Felipe');
        $customer->setEmail('felipe.ralc@gmail.com');
        $customer->setCpf('431.036.028-98');
        $customer->setPassword(bcrypt('asdf123'));
        $customer->setCreatedAt(Carbon::now());

        //$this->entityManager->persist($customer);
        //$this->entityManager->flush();

        //dd($repo->find(17));

        return $this->view('home.index');
    }

}
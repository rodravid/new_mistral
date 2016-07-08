<?php

namespace Vinci\App\Cms\Http\Tests;

use Doctrine\ORM\EntityManagerInterface;
use View;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Website\Http\Customer\Presenters\CustomerPresenter;
use Vinci\App\Website\Http\Order\Presenter\OrderPresenter;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Order\OrderRepository;

class CustomerMailTemplateController extends Controller
{

    private $customerRepository;

    public function __construct(EntityManagerInterface $em, CustomerRepository $customerRepository)
    {
        parent::__construct($em);

        $this->customerRepository = $customerRepository;
    }

    public function render($namespace, $template, $customer)
    {
        $customer = $this->customerRepository->findByDocument($customer);

        $customer = $this->presenter->model($customer, CustomerPresenter::class);

        return View::make('website::layouts.emails.account.' . $namespace . '.' . $template, compact('customer'));
    }

}
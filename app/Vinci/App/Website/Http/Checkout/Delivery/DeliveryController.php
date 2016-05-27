<?php

namespace Vinci\App\Website\Http\Checkout\Delivery;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Checkout\Presenters\AddressPresenter;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Customer\Address\AddressRepository;

class DeliveryController extends Controller
{
    protected $customerService;

    protected $addressRepository;

    public function __construct(EntityManagerInterface $em, AddressRepository $addressRepository)
    {
        parent::__construct($em);

        $this->addressRepository = $addressRepository;
    }

    public function index()
    {
        $addresses = $this->addressRepository->getAllByCustomer($this->user);

        $addresses = $this->presenter->collection($addresses, AddressPresenter::class);

        return $this->view('checkout.delivery.index', compact('addresses'));
    }

}
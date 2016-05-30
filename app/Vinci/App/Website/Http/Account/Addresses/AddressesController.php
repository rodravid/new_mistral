<?php

namespace Vinci\App\Website\Http\Account\Addresses;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Customer\Address\AddressPresenter;
use Vinci\Domain\Customer\Address\AddressRepository;

class AddressesController extends Controller
{

    private $addressRepository;

    public function __construct(EntityManagerInterface $em, AddressRepository $addressRepository)
    {
        parent::__construct($em);

        $this->addressRepository = $addressRepository;
    }

    public function index()
    {
        $addresses = $this->addressRepository->getAllByCustomer($this->user);

        $addresses = $this->presenter->collection($addresses, AddressPresenter::class);

        return $this->view('account.addresses.index', compact('addresses'));
    }

}
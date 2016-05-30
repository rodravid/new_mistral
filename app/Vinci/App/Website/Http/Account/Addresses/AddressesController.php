<?php

namespace Vinci\App\Website\Http\Account\Addresses;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use ReflectionObject;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Address\City\CityRepository;
use Vinci\Domain\Customer\Address\Address;
use Vinci\Domain\Customer\Address\AddressPresenter;
use Vinci\Domain\Customer\Address\AddressRepository;

class AddressesController extends Controller
{

    private $addressRepository;

    private $cityRepository;

    public function __construct(EntityManagerInterface $em, AddressRepository $addressRepository, CityRepository $cityRepository)
    {
        parent::__construct($em);

        $this->addressRepository = $addressRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        $addresses = $this->addressRepository->getAllByCustomer($this->user);

        $addresses = $this->presenter->collection($addresses, AddressPresenter::class);

        return $this->view('account.addresses.index', compact('addresses'));
    }

    public function getAddressModal(Request $request)
    {
        $address = $this->getAddressForModal($request);
        $cities = [];

        if ($address->getId() > 0) {

            $state = $address->getState();

            $cities = $this->cityRepository->getByState($state->getId());
        }

        return $this->view('layouts.modals.address.default', compact('address', 'cities'));
    }

    protected function getAddressForModal(Request $request)
    {
        if (! empty($request->get('address_id'))) {
            return $this->addressRepository->getOneById($request->get('address_id'));
        }

        $address = new Address();
        $r = new ReflectionObject($address);
        $property = $r->getProperty('id');
        $property->setAccessible(true);
        $property->setValue($address, 0);

        return $address;
    }

}
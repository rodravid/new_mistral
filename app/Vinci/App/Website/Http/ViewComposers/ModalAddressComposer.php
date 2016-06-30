<?php

namespace Vinci\App\Website\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\Domain\Address\Country\Country;
use Vinci\Domain\Address\Country\CountryRepository;
use Vinci\Domain\Address\PublicPlaceRepository;
use Vinci\Domain\Address\State\StateRepository;

class ModalAddressComposer
{

    private $countryRepository;

    private $stateRepository;

    private $publicPlaceRepository;

    public function __construct(CountryRepository $countryRepository, StateRepository $stateRepository, PublicPlaceRepository $publicPlaceRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
        $this->publicPlaceRepository = $publicPlaceRepository;
    }

    public function compose(View $view)
    {
        $country = $this->countryRepository->find(Country::BRAZIL);
        $states = $this->stateRepository->getByCountry($country);
        $publicPlaces = $this->publicPlaceRepository->getAll();

        $view->with('country', $country);
        $view->with('states', $states);
        $view->with('publicPlaces', $publicPlaces);

    }

}
<?php

namespace Vinci\App\Website\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\Domain\Address\Country\Country;
use Vinci\Domain\Address\Country\CountryRepository;
use Vinci\Domain\Address\State\StateRepository;

class ModalAddressComposer
{

    private $countryRepository;

    private $stateRepository;

    public function __construct(CountryRepository $countryRepository, StateRepository $stateRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
    }

    public function compose(View $view)
    {
        $country = $this->countryRepository->find(Country::BRAZIL);

        $states = $this->stateRepository->getByCountry($country);

        $view->with('country', $country);
        $view->with('states', $states);
    }

}
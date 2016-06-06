<?php

namespace Vinci\App\Website\Http\Country;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Country\CountryRepository;

class CountryController extends Controller
{

    private $countryRepository;

    public function __construct(
        EntityManagerInterface $em,
        CountryRepository $countryRepository
    ) {
        parent::__construct($em);

        $this->countryRepository = $countryRepository;
    }

    public function show($slug)
    {
        $country = $this->countryRepository->getOneBySlug($slug);

        $country = $this->presenter->model($country, CountryPresenter::class);

        return $this->view('country.index', compact('country'));
    }

}
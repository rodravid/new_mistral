<?php
namespace Vinci\App\Integration\ERP\City;

class CityService
{

    private $cityApi;

    private $cityRepository;

    public function __construct(CityApi $cityApi, CityRepository $cityRepository)
    {
        $this->cityApi = $cityApi;
        $this->cityRepository = $cityRepository;
    }

    public function getCitiesFromState($stateId)
    {
        return $this->cityApi->getAllCitiesOfState($stateId);
    }

    public function syncCity($city)
    {
        if ($this->cityRepository->exists($city['ibge_code'])) {
            $this->cityRepository->updateCity($city);

        } else {
            $this->cityRepository->createCity($city);

        }
    }

}
<?php
namespace Vinci\App\Integration\ERP\State;

class StateService
{

    private $stateApi;

    private $stateRepository;

    public function __construct(StateApi $stateApi, StateRepository $stateRepository)
    {
        $this->stateApi = $stateApi;
        $this->stateRepository = $stateRepository;
    }

    public function syncAllStatesOfCountry($countryId)
    {
        $states = $this->stateApi->getAllStatesOfCountry($countryId);
        return $this->stateRepository->syncStates($states);
    }

    public function getStatesToSyncFromCountry($countryId)
    {
        return $this->stateApi->getAllStatesOfCountry($countryId);
    }

    public function syncState($state)
    {
        $this->stateRepository->syncState($state);
    }

}
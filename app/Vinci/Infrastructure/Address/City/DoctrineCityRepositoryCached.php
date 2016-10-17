<?php

namespace Vinci\Infrastructure\Address\City;

use Illuminate\Contracts\Cache\Repository as Cache;
use Vinci\Domain\Address\City\CityRepository;

class DoctrineCityRepositoryCached implements CityRepository
{

    protected $cityRepository;

    protected $cache;

    public function __construct(CityRepository $cityRepository, Cache $cache)
    {
        $this->cityRepository = $cityRepository;
        $this->cache = $cache;
    }

    public function find($id)
    {
        return $this->cache->rememberForever($this->getCacheKey('find-' . $id), function() use ($id) {
            return $this->cityRepository->find($id);
        });
    }

    public function getByState($state)
    {
        return $this->cache->rememberForever($this->getCacheKey('by-state-' . $state), function() use ($state) {
            return $this->cityRepository->getByState($state);
        });
    }

    public function getCacheKey($key)
    {
        return 'city-repository' . trim($key);
    }

    public function exists($id)
    {
        return $this->cityRepository->exists($id);
    }

    public function createCity(array $data)
    {
        return $this->cityRepository->createCity($data);
    }

    public function updateCity(array $data)
    {
        $this->cityRepository->updateCity($data);
    }
}
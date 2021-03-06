<?php

namespace Vinci\Infrastructure\Address\State;

use Illuminate\Contracts\Cache\Repository as Cache;
use Vinci\Domain\Address\State\StateRepository;

class DoctrineStateRepositoryCached implements StateRepository
{

    protected $stateRepository;

    protected $cache;

    public function __construct(StateRepository $stateRepository, Cache $cache)
    {
        $this->stateRepository = $stateRepository;
        $this->cache = $cache;
    }

    public function find($id)
    {
        return $this->cache->rememberForever($this->getCacheKey('find-', $id), function() use ($id) {
            return $this->stateRepository->find($id);
        });
    }

    public function getByCountry($country)
    {
        return $this->cache->rememberForever($this->getCacheKey('by-country-', $country), function() use ($country) {
            return $this->stateRepository->getByCountry($country);
        });
    }

    public function getAllStateIDs()
    {
        return $this->stateRepository->getAllStateIDs();
    }

    protected function getCacheKey($key, $data)
    {
        if (is_object($data)) {
            $data = spl_object_hash($data);
        }

        return 'state-repository-' . trim($key) . trim($data);
    }

    public function syncState($state)
    {
        $this->stateRepository->syncState($state);
    }

    public function syncStates($states, $detach = false)
    {
        return $this->stateRepository->syncStates($states, $detach);
    }

    public function create(array $data)
    {
        return $this->stateRepository->create($data);
    }

    public function update(array $data)
    {
        return $this->stateRepository->update($data);
    }
}
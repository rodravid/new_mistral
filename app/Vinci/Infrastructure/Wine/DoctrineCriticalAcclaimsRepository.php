<?php

namespace Vinci\Infrastructure\Wine;


use Vinci\Domain\Product\Wine\Repositories\CriticalAcclaimsRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineCriticalAcclaimsRepository extends DoctrineBaseRepository implements CriticalAcclaimsRepository
{
    public function getAll()
    {
        $query = $this->createQueryBuilder('wca')
                      ->select('wca')
                      ->orderBy('wca.id');

        $wineCriticalAcclaims = $query->getQuery()->getResult();

        return $wineCriticalAcclaims;
    }
}
<?php
namespace Vinci\Infrastructure\Address\PublicPlace;

use Vinci\Domain\Address\PublicPlaceRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrinePublicPlaceRepository extends DoctrineBaseRepository implements PublicPlaceRepository
{

    public function getAll()
    {
        return $this->createQueryBuilder('PublicPlaces')->select('PublicPlaces')->getQuery()->getResult();
    }
}
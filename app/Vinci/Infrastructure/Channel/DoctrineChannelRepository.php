<?php

namespace Vinci\Infrastructure\Channel;

use Vinci\Domain\Channel\ChannelRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineChannelRepository extends DoctrineBaseRepository implements ChannelRepository
{

    public function getDefaultChannel()
    {
        $dql = 'SELECT c FROM Vinci\Domain\Channel\Channel c WHERE c.default = true ORDER BY c.createdAt DESC';
        $query = $this->_em->createQuery($dql);
        $query->setMaxResults(1);

        return $query->getOneOrNullResult();
    }

    public function findByCode($code)
    {
        $dql = 'SELECT c FROM Vinci\Domain\Channel\Channel c WHERE c.code = :code';
        $query =  $this->_em->createQuery($dql);

        $query->setParameter('code', $code);

        return $query->getOneOrNullResult();
    }
}
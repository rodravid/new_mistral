<?php

namespace Vinci\Infrastructure\Channel;

use Vinci\Domain\Channel\ChannelRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineChannelRepository extends DoctrineBaseRepository implements ChannelRepository
{

    public function getDefaultChannel()
    {
        $query = 'SELECT c FROM Vinci\Domain\Channel\Channel c WHERE c.default = true';
        return $this->_em->createQuery($query)->getOneOrNullResult();
    }
}
<?php

namespace Vinci\Infrastructure\Common;

use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class DoctrineBaseRepository extends EntityRepository
{
    use Paginatable;

    public function save($entity)
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    public function delete($entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

}
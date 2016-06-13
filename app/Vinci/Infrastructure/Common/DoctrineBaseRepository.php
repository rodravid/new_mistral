<?php

namespace Vinci\Infrastructure\Common;

use Doctrine\ORM\EntityRepository;
use Vinci\Infrastructure\Common\Traits\Paginatable;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineBaseRepository extends EntityRepository
{
    use Paginatable;

    public function findOrFail($id)
    {
        $entity = $this->find($id);

        if (! $entity) {
            throw new EntityNotFoundException('Entity not found.');
        }

        return $entity;
    }

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
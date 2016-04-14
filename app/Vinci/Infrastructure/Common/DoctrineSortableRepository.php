<?php

namespace Vinci\Infrastructure\Common;

use Gedmo\Sortable\Entity\Repository\SortableRepository;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

class DoctrineSortableRepository extends SortableRepository
{

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
        return $entity;
    }

    public function delete($entity)
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }

}
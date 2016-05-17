<?php

namespace Vinci\Domain\Grape;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;

class GrapeFactory
{

    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function make(array $data)
    {
        $grape = $this->getNewGrapeInstance($data);

        return $grape;
    }

    public function makeCollection(array $data)
    {
        $grapes = new ArrayCollection;

        foreach ($data as $item) {
            $grapes->add($this->make($item));
        }

        return $grapes;
    }

    public function getNewGrapeInstance($data)
    {
        if (isset($data['id'])) {
            $grape = $this->entityManager->getReference(Grape::class, $data['id']);
        } else {
            $grape = new Grape;
        }

        return $grape;
    }

}
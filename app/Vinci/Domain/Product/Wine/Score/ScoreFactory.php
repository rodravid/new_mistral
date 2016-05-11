<?php

namespace Vinci\Domain\Product\Wine\Score;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\Product\Wine\Score;

class ScoreFactory
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function make(array $data)
    {
        $score = $this->getNewInstance($data);

        $score
            ->setTitle($data['title'])
            ->setDescription($data['description'])
            ->setHighlight($data['highlighted'])
            ->setValue($data['value'])
            ->setYear($data['year']);

        return $score;

    }

    public function makeCollection(array $data)
    {
        $scores = new ArrayCollection;

        foreach ($data as $item) {
            $scores->add($this->make($item));
        }

        return $scores;
    }

    protected function getNewInstance($data)
    {
        if (isset($data['id']) && ! empty($data['id'])) {
            $score = $this->entityManager->getReference(Score::class, $data['id']);

            return $score;
        }

        return new Score;

    }

}
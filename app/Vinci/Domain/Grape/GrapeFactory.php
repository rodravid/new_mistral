<?php

namespace Vinci\Domain\Grape;

use Doctrine\Common\Collections\ArrayCollection;

class GrapeFactory
{

    public function makeFromArray(array $data)
    {
        $line = $this->getNewLineInstance();

        $line->setInitialTrack($data['initial_track'])
            ->setFinalTrack($data['final_track'])
            ->setDescription($data['description']);

        return $line;
    }

    public function makeCollectionFromArray(array $lines)
    {
        $linesCollection = new ArrayCollection;

        foreach ($lines as $line) {
            $linesCollection->add($this->makeFromArray($line));
        }

        return $linesCollection;
    }

    public function getNewLineInstance()
    {
        return new Grape;
    }

}
<?php

namespace Vinci\Domain\Product\Wine;

use Vinci\Domain\Grape\GrapeFactory;

class GrapeContentFactory
{

    protected $grapeFactory;

    public function __construct(GrapeFactory $grapeFactory)
    {
        $this->grapeFactory = $grapeFactory;
    }

    public function makeFromArray(array $data)
    {
        $grapeContent = $this->getNewGrapeContentIntance();

        $grapeContent->setGrape()
            ->setWine($data['final_track'])
            ->setWeight($data['description']);

        return $grapeContent;
    }

    public function makeCollectionFromArray(array $grapeContents)
    {
        $grapeContentsCollection = new ArrayCollection;

        foreach ($grapeContents as $grapeContent) {
            $grapeContentsCollection->add($this->makeFromArray($grapeContent));
        }

        return $grapeContentsCollection;
    }

    public function getNewGrapeContentIntance()
    {
        return new GrapeContent;
    }

}
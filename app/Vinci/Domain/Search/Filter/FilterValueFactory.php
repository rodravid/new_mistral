<?php

namespace Vinci\Domain\Search\Filter;

use Doctrine\Common\Collections\ArrayCollection;

class FilterValueFactory
{

    public function make(array $data)
    {
        $value = $this->getNewInstance();

        $value
            ->setTitle(array_get($data, 'key'))
            ->setCount(array_get($data, 'doc_count'));

        return $value;
    }

    public function makeCollection(array $items)
    {
        $collection = new ArrayCollection;

        foreach ($items as $item) {
            $collection->add($this->make($item));
        }

        return $collection;
    }

    public function getNewInstance()
    {
        return new FilterValue;
    }

}
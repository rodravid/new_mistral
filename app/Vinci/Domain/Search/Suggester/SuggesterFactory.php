<?php

namespace Vinci\Domain\Search\Suggester;

use Doctrine\Common\Collections\ArrayCollection;

class SuggesterFactory
{

    public function make(array $data)
    {
        $data = $data[0];

        $suggester = $this->getNewInstance();

        $name = array_get($data, 'name');

        $suggester->setName($name);

        $options = new ArrayCollection;

        foreach (array_get($data, 'options') as $op) {

            $option = new SuggesterOption;

            $option->setText(array_get($op, 'text'))
                ->setScore(array_get($op, 'score'))
                ->setPayload(array_get($op, 'payload'));

            $options->add($option);
        }

        $suggester->setOptions($options);

        return $suggester;
    }

    public function makeCollection(array $items)
    {

        $collection = new ArrayCollection;

        foreach ($items as $key => $item) {

            $suggester = $this->make($item);

            $suggester->setName($key);

            $collection->add($suggester);
        }

        return $collection;
    }

    public function getNewInstance()
    {
        return new Suggester;
    }

}
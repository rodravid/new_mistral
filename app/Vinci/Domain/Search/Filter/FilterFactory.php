<?php

namespace Vinci\Domain\Search\Filter;

use Doctrine\Common\Collections\ArrayCollection;

class FilterFactory
{

    protected $filterValueFactory;

    protected $titles;

    public function __construct(FilterValueFactory $filterValueFactory)
    {
        $this->filterValueFactory = $filterValueFactory;
    }

    public function make(array $data)
    {
        $filter = $this->getNewInstance();

        $name = array_get($data, 'name');
        $title = $this->getFilterTitle($name);

        $filter
            ->setName($name)
            ->setTitle($title);

        return $filter;
    }

    public function makeCollection(array $items)
    {
        $collection = new ArrayCollection;

        foreach ($items as $key => $item) {


//            if ($key == 'regiao') {
//                continue;
//            }
//
//            if ($key == 'pais') {
//                dd($item);
//            }

            $filter = $this->make(['name' => $key]);

            $buckets = isset($item[$key]) ? array_get($item[$key], 'buckets') : array_get($item, 'buckets');

            $values = $this->filterValueFactory->makeCollection($buckets);

            foreach ($values as $value) {
                $value->setFilter($filter);
            }

            $filter->setValues($values);

            $collection->add($filter);
        }

        return $collection;
    }

    public function getNewInstance()
    {
        return new Filter;
    }

    protected function getFilterTitle($name)
    {
        return $this->titles[$name];
    }

    public function getTitles()
    {
        return $this->titles;
    }

    public function setTitles(array $titles)
    {
        $this->titles = $titles;
    }

}
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

            $filter = $this->make(['name' => $key]);

            $values = $this->filterValueFactory->makeCollection(array_get($item, 'buckets'));

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
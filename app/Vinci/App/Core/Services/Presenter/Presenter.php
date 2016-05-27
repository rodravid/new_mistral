<?php

namespace Vinci\App\Core\Services\Presenter;

use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;

class Presenter
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function model($model, $presenterClass)
    {
        return $this->container->make($presenterClass, [$model]);
    }

    public function collection($collection, $presenterClass)
    {
        if (is_array($collection)) {

            $items = [];

            foreach($collection as $key => $value)
            {
                $items[$key] = $this->model($value, $presenterClass);
            }

            return $items;

        } else if ($collection instanceof ArrayCollection) {
            return $this->doctrineCollection($collection, $presenterClass);

        } else if ($collection instanceof Collection) {
            return $this->laravelCollection($collection, $presenterClass);
        }

        throw new Exception('The given collection not is valid.');
    }

    protected function doctrineCollection(ArrayCollection $collection, $presenterClass)
    {
        foreach($collection as $key => $value)
        {
            $collection->set($key, $this->model($value, $presenterClass));
        }

        return $collection;
    }

    protected function laravelCollection(Collection $collection, $presenterClass)
    {
        foreach($collection as $key => $value)
        {
            $collection->put($key, $this->model($value, $presenterClass));
        }

        return $collection;
    }

}
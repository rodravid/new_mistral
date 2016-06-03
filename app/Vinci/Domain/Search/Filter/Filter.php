<?php

namespace Vinci\Domain\Search\Filter;

use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Search\Presenters\FilterPresenter;

class Filter implements Presentable
{

    use PresentableTrait;

    protected $presenter = FilterPresenter::class;

    protected $title;

    protected $name;

    protected $values;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function setValues($values)
    {
        $this->values = $values;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}
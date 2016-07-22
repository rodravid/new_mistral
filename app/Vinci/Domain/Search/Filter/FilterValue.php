<?php

namespace Vinci\Domain\Search\Filter;

use Vinci\App\Core\Services\Presenter\Presentable;
use Vinci\App\Core\Services\Presenter\PresentableTrait;
use Vinci\Domain\Search\Presenters\FilterValuePresenter;

class FilterValue implements Presentable
{

    use PresentableTrait;

    protected $presenter = FilterValuePresenter::class;

    protected $title;

    protected $count = 0;

    protected $filter;

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setCount($count)
    {
        $this->count = (int) $count;
        return $this;
    }

    public function getFilter()
    {
        return $this->filter;
    }

    public function setFilter(Filter $filter)
    {
        $this->filter = $filter;
        return $this;
    }

}
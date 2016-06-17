<?php

namespace Vinci\Domain\Search\Result;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class SearchResult
{

    protected $term;

    protected $limit;

    protected $start;

    protected $total = 0;

    protected $items;

    protected $filters;

    protected $visibleFilters;

    protected $selectedFilters;

    public function __construct()
    {
        $this->items = [];
        $this->filters = new ArrayCollection;
        $this->visibleFilters = '*';
        $this->selectedFilters = [];
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = (int) $total;
        return $this;
    }

    public function hasItems()
    {
        return count($this->items) > 0;
    }

    public function getTerm()
    {
        return $this->term;
    }

    public function setTerm($term)
    {
        $this->term = $term;
        return $this;
    }

    public function getFilters()
    {
       return $this->filters;
    }

    public function setFilters($filters)
    {
        $this->filters = $filters;
        return $this;
    }

    public function getVisibleFilters()
    {
        if ($this->visibleFilters == '*') {
            return $this->filters;
        }

        $expr = Criteria::expr();
        $criteria = Criteria::create();

        $criteria->where($expr->in('name', $this->visibleFilters));

        return $this->filters->matching($criteria);
    }

    public function setVisibleFilters($visibleFilters)
    {
        $this->visibleFilters = $visibleFilters;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setLimit($limit)
    {
        $this->limit = (int) $limit;
        return $this;
    }

    public function getStart()
    {
        return $this->start;
    }

    public function setStart($start)
    {
        $this->start = (int) $start;
        return $this;
    }

    public function getSelectedFilters()
    {
        return $this->selectedFilters;
    }

    public function setSelectedFilters($selectedFilters)
    {
        $this->selectedFilters = $selectedFilters;
        return $this;
    }

}
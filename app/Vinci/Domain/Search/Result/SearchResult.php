<?php

namespace Vinci\Domain\Search\Result;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Illuminate\Support\Collection;
use Vinci\Domain\Search\Filter\Filter;

class SearchResult
{

    protected $term;

    protected $sort;

    protected $limit;

    protected $start;

    protected $total = 0;

    protected $items;

    protected $filters;

    protected $visibleFilters;

    protected $selectedFilters;

    protected $suggesters;

    public function __construct()
    {
        $this->items = [];
        $this->filters = new ArrayCollection;
        $this->suggesters = new ArrayCollection;
        $this->visibleFilters = [];
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

    public function addFilter(Filter $filter)
    {
        $this->filters->add($filter);
        return $this;
    }

    public function getVisibleFilters()
    {
        $filters = [];
        foreach ($this->visibleFilters as $vf) {
            foreach ($this->filters as $f) {
                if ($vf == $f->getName()) {
                    $filters[] = $f;
                }
            }
        }

        return collect($filters);
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
        if ($this->selectedFilters instanceof Collection) {
            return $this->selectedFilters;
        }

        $filters = [];

        foreach ($this->selectedFilters as $key => $values) {
            foreach ($this->cloneFilters() as $f) {
                if ($key == $f->getName()) {

                    $selectedValues = [];

                    foreach ($f->getValues() as $val) {
                        foreach ($values as $v) {
                            if ($val->getTitle() == $v) {
                                $selectedValues[] = $val;
                            }
                        }
                    }

                    $f->setValues(new ArrayCollection($selectedValues));
                    $filters[] = $f;
                }
            }
        }

        return $this->selectedFilters = collect($filters);
    }

    public function cloneFilters()
    {
        $cloned = new ArrayCollection();

        foreach ($this->filters as $filter) {
            $cloned->add(clone $filter);
        }

        return $cloned;
    }

    public function setSelectedFilters($selectedFilters)
    {
        $this->selectedFilters = $selectedFilters;
        return $this;
    }

    public function getSort()
    {
        return $this->sort;
    }

    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    public function getSuggesters()
    {
        return $this->suggesters;
    }

    public function setSuggesters(ArrayCollection $suggesters)
    {
        $this->suggesters = $suggesters;
        return $this;
    }

    public function getSuggester($name)
    {
        $criteria = Criteria::create();

        $criteria->where($criteria->expr()->eq('name', $name));

        return $this->suggesters->matching($criteria)->first();
    }

}
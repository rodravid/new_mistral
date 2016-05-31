<?php

namespace Vinci\Domain\Search\Product\Result;

class ProductSearchResult
{

    protected $term;

    protected $items;

    protected $total = 0;

    public function __construct()
    {
        $this->items = [];
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

}
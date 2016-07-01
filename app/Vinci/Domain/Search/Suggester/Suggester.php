<?php

namespace Vinci\Domain\Search\Suggester;

use Doctrine\Common\Collections\ArrayCollection;

class Suggester
{

    protected $name;

    protected $options;

    public function __construct()
    {
        $this->options = new ArrayCollection;
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

    public function getOptions()
    {
        return $this->options;
    }

    public function setOptions(ArrayCollection $options)
    {
        $this->options = $options;
        return $this;
    }

}
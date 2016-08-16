<?php

namespace Vinci\Domain\Search\Indexing;

abstract class AbstractIndex implements Index
{

    public abstract function getName();

    protected abstract function getConfiguration();

    public function getDefinition()
    {
        $definition = array_merge(['index' => $this->getName()], ['body' => $this->getConfiguration()]);

        return $definition;
    }

    public function __toString()
    {
        return json_encode($this->getDefinition());
    }

}
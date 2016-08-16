<?php

namespace Vinci\Domain\Search\Indexing;

interface Index
{

    public function getName();

    public function getDefinition();

}
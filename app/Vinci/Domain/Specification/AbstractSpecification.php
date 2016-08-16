<?php

namespace Vinci\Domain\Specification;

abstract class AbstractSpecification
{

    public function andSpecification(AbstractSpecification $other)
    {
        return new AndSpecification($this, $other);
    }

}
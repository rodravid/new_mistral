<?php

namespace Vinci\Domain\File\Mapping;

use Vinci\Domain\File\Builders\DefaultPathBuilder;

abstract class FileMapping
{
    protected $pathBuilder = DefaultPathBuilder::class;

    public function withPathBuilder($builder) {
        $this->pathBuilder = $builder;
        return $this;
    }

    public function getPathBuilder() {
        return $this->pathBuilder;
    }

    public function getFolder() {
        return "files";
    }
    public abstract function getHasMany();
    public abstract function getIdentifier();


}
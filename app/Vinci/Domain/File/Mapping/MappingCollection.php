<?php

namespace Vinci\Domain\File\Mapping;

class MappingCollection
{
    protected $mappingCollection = [];

    public function addMapping(FileMapping $mapping) {
        $this->mappingCollection[] = $mapping;
    }

    public function hasIdentifier($identifier) {
        return $this->getMapping($identifier) !== null;
    }

    public function getMapping($identifier) {
        
        foreach($this->mappingCollection as $mapping) {
            if($mapping->getIdentifier() === $identifier)
                return $mapping;
        }

        return null;
    }
}
<?php

namespace Vinci\Domain\File\Mapping;

class DefaultFileMapping extends FileMapping
{
    protected $identifier = "";
    protected $hasMany = false;
    protected $folder = "files";

    public function withIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function withFolder($folder)
    {
        $this->folder = $folder;
        return $this;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function setHasMany($hasMany)
    {
        $this->hasMany = $hasMany;
    }

    public function getHasMany()
    {
        return $this->hasMany;
    }

    public function getFolder()
    {
        return $this->folder;
    }


}
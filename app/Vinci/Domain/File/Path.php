<?php

namespace Vinci\Domain\File;

class Path
{
    private $filename;

    private $path;

    public function __construct($filename, $path)
    {
        $this->filename = $filename;
        $this->path = $path;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getPath()
    {
        return $this->path;
    }
}
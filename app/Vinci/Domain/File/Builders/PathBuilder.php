<?php

namespace Vinci\Domain\File\Builders;

use Vinci\Domain\File\Mapping\FileMapping;
use Illuminate\Http\UploadedFile;

abstract class PathBuilder
{
    protected $fullpath;
    protected $filename;
    protected $folderPath;

    public abstract function buildFileName(FileMapping $mapping, UploadedFile $uploadedFile);

    public function build(FileMapping $mapping, UploadedFile $uploadedFile) {
        $folder = $mapping->getFolder();
        $this->setFilename($this->buildFileName($mapping, $uploadedFile));
        $fullpath = $this->getUniqueFilePath($this->getFilename(), $folder);
        $this->setFullpath($fullpath);
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getFullpath()
    {
        return $this->fullpath;
    }

    public function setFullpath($fullpath)
    {
        $this->fullpath = $fullpath;
    }

    public function getFolderPath()
    {
        return $this->folderPath;
    }

    private function setFolderPath($folderPath)
    {
        $this->folderPath = $folderPath;
    }

    public function getUniqueFilePath($filename, $folder = "")
    {
        $uniqueId = uniqid();
        $prefix = substr($uniqueId, 0, 4);
        $folderPath = "{$uniqueId[0]}/{$uniqueId[1]}";
        $filename = "{$prefix}-$filename";

        if(!empty($folder)) {
            $folderPath = "$folder/{$folderPath}";

        }

        $this->setFolderPath($folderPath);
        $this->setFilename($filename);

        return "$folderPath/$filename";
    }

}
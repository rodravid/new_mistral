<?php

namespace Vinci\Domain\File\Builders;

use Vinci\Domain\File\Mapping\FileMapping;
use Illuminate\Http\UploadedFile;

class DefaultPathBuilder extends PathBuilder
{
    public function buildFileName(FileMapping $mapping, UploadedFile $uploadedFile)
    {
        $extension = $uploadedFile->getClientOriginalExtension();
        return "{$mapping->getIdentifier()}.$extension";
    }
}
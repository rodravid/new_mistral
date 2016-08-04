<?php

namespace Vinci\Domain\File\Factories;

use Vinci\Domain\File\Builders\PathBuilder;
use Vinci\Domain\File\File;
use Vinci\Domain\File\Mapping\FileMapping;
use Illuminate\Http\UploadedFile;

abstract class FileFactory
{
    public function make(FileMapping $mapping, PathBuilder $builder, UploadedFile $file) {
        
        $builder->build($mapping, $file);

        return File::make([
            'caption' => $file->getClientOriginalName(),
            'extension' => $file->getClientOriginalExtension(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'path' => $builder->getFolderPath(),
            'name' => $builder->getFilename()
        ]);
    }
}
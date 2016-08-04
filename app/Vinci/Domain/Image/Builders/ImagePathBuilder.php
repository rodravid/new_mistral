<?php

namespace Vinci\Domain\Image\Builders;

use Vinci\Domain\File\Builders\PathBuilder;
use Vinci\Domain\File\Mapping\FileMapping;
use Illuminate\Http\UploadedFile;

class ImagePathBuilder extends PathBuilder
{
    public function buildFileName(FileMapping $mapping, UploadedFile $uploadedFile)
    {
        $extension = $uploadedFile->getClientOriginalExtension();
        $dimensions = getimagesize($uploadedFile);
        $width = $dimensions[0];
        $height = $dimensions[1];
        return "{$mapping->getIdentifier()}-{$width}x{$height}.{$extension}";
    }
}
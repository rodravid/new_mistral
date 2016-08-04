<?php

namespace Vinci\Domain\File\Builders;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vinci\Domain\File\Mapping\FileMapping;

interface PathBuilderInterface
{

    public function build(FileMapping $mapping, UploadedFile $uploadedFile);

}
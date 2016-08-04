<?php

namespace Vinci\Domain\Product\Image;

use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vinci\Domain\File\Builders\PathBuilderInterface;
use Vinci\Domain\File\Mapping\FileMapping;
use Vinci\Domain\File\Path;
use Vinci\Domain\Product\ProductInterface;

class ProductImagePathBuilder implements PathBuilderInterface
{

    protected $product;

    public function __construct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function build(FileMapping $mapping, UploadedFile $uploadedFile)
    {
        return new Path(
            $this->buildFilename($mapping, $uploadedFile),
            $this->buildPath()
        );
    }

    protected function buildFilename(FileMapping $mapping, UploadedFile $uploadedFile)
    {
        $size = getimagesize($uploadedFile);

        return sprintf('vinho-%s-%s-%sx%s', $this->product->getSlug(), Str::slug($this->product->getProducer()->getName()), $size[0], $size[1]);
    }

    protected function buildPath()
    {
        return sprintf('products/%s/images', $this->product->getSku());
    }

}
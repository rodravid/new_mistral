<?php

namespace Vinci\Infrastructure\Storage;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Config\Repository as Config;
use Vinci\Domain\File\FileInterface;
use Vinci\Domain\Image\Image;

class StorageService
{
    protected $filesystem;

    protected $disk;

    protected $config;

    public function __construct(Factory $filesystem, Config $config)
    {
        $this->filesystem = $filesystem;
        $this->config = $config;
    }

    public function disk($name = null)
    {
        $name = $name ?: $this->getDefaultDisk();
        return $this->disk = $this->get($name);
    }

    public function storeImage(Image $image)
    {
        $uploadedImage = $image->getUploadedFile();

        if (empty($image->getName())) {
            $image->generateUniqueName();
        }

        $this->disk()->put($image->getUploadPathName(), file_get_contents($uploadedImage));

        if ($image->hasSmall()) {
            $this->disk()->put($image->getSmall()->getUploadPathName(), file_get_contents($uploadedImage));
        }

        return $image->getPathName();
    }

    protected function getDefaultDisk()
    {
        return $this->config['filesystems.default'];
    }

    protected function get($name)
    {
        return $this->filesystem->disk($name);
    }

    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->disk(), $method], $parameters);
    }

}
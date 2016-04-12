<?php

namespace Vinci\Infrastructure\Storage;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Config\Repository as Config;
use RuntimeException;
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
            throw new RuntimeException('The image name cannot be empty.');
        }

        $this->disk()->put($image->getUploadPathName(), file_get_contents($uploadedImage));

        if ($image->hasVersions()) {

            foreach ($image->getVersions() as $version) {
                $this->storeImage($version);
            }

        }

        return $image;
    }

    public function deleteImage(Image $image)
    {
        $this->disk()->delete($image->getUploadPathName());

        if ($image->hasVersions()) {

            foreach ($image->getVersions() as $version) {
                $this->deleteImage($version);
            }

        }

        return $image;
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
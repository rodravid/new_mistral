<?php

namespace Vinci\Infrastructure\Storage;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Config\Repository as Config;
use Vinci\Domain\File\FileInterface;
use Vinci\Domain\Photo\Photo;

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

    public function storePhoto(Photo $photo, $contents)
    {
        return $this->disk()->put($photo->getUploadPath(), $contents);
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
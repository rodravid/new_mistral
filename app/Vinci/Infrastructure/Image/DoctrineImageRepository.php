<?php

namespace Vinci\Infrastructure\Image;

use Vinci\Domain\Image\ImageRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineImageRepository extends DoctrineBaseRepository implements ImageRepository
{

    public function save($image)
    {
        if (empty($image->getName())) {
            $image->generateUniqueName();
        }

        $this->_em->persist($image);
        $this->_em->flush();
        return $image;
    }

}
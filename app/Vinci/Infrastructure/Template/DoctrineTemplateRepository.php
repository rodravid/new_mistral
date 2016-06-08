<?php

namespace Vinci\Infrastructure\Template;

use Vinci\Domain\Template\TemplateRepository;
use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineTemplateRepository extends DoctrineBaseRepository implements TemplateRepository
{
    public function getAll()
    {
        return $this->createQueryBuilder('t')->getQuery()->getResult();
    }
}
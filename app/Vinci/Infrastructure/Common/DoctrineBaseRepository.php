<?php

namespace Vinci\Infrastructure\Common;

use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class DoctrineBaseRepository extends EntityRepository
{
    use Paginatable;

}
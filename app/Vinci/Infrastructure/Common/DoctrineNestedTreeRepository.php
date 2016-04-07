<?php

namespace Vinci\Infrastructure\Common;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class DoctrineNestedTreeRepository extends NestedTreeRepository
{
    use Paginatable;

}
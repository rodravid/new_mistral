<?php

namespace Vinci\Infrastructure\Common;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Vinci\Infrastructure\Common\Traits\Paginatable;

class DoctrineNestedTreeRepository extends NestedTreeRepository
{
    use Paginatable;

}
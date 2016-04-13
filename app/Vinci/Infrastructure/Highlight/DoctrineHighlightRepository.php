<?php

namespace Vinci\Infrastructure\Highlight;

use Vinci\Domain\Highlight\Highlight;
use Vinci\Domain\Highlight\HighlightRepository;
use Vinci\Infrastructure\Users\DoctrineUserRepository;

class DoctrineHighlightRepository extends DoctrineUserRepository implements HighlightRepository
{

    public function create(array $data)
    {
        $admin = Highlight::make($data);
        $this->_em->persist($admin);
        $this->_em->flush();
        return $admin;
    }

}
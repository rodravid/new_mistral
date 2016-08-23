<?php

namespace Vinci\Infrastructure\Users;

use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineUserRepository extends DoctrineBaseRepository
{

    public function findByEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function findByRole(array $role)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->join('a.roles', 'r')
            ->where($qb->expr()->in('r.name', $role));

        return $qb->getQuery()->getResult();

    }

}
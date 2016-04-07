<?php

namespace Vinci\Infrastructure\Users;

use Vinci\Infrastructure\Common\DoctrineBaseRepository;

class DoctrineUserRepository extends DoctrineBaseRepository
{

    public function findByEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }

}
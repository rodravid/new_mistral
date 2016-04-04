<?php

namespace Vinci\Infrastructure\Admin;

use Vinci\Domain\Admin\Admin;
use Vinci\Domain\Admin\AdminRepository;
use Vinci\Infrastructure\Users\DoctrineUserRepository;

class DoctrineAdminRepository extends DoctrineUserRepository implements AdminRepository
{

    public function create(array $data)
    {
        $admin = Admin::make($data);
        $this->_em->persist($admin);
        $this->_em->flush();
        return $admin;
    }

}
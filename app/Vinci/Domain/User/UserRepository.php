<?php

namespace Vinci\Domain\User;

use Vinci\App\Core\Contracts\RepositoryInterface;

interface UserRepository extends RepositoryInterface
{

    public function create(array $data);

    public function findByEmail($email);

}
<?php

namespace Vinci\Domain\User\Admin;

use Vinci\Domain\User\UserRepository;

interface AdminRepository extends UserRepository
{

    public function createProfile(array $attributes, $adminId);

    public function updateProfile(array $attributes, $adminId);

}
<?php

namespace Vinci\Infrastructure\Users;

use Illuminate\Contracts\Auth\UserProvider;
use Vinci\Domain\User\Admin\Admin;
use Vinci\Domain\User\Admin\AdminRepository;
use Vinci\Infrastructure\Users\Criteria\AdminCriteria;

class EloquentAdminRepository extends EloquentUserRepository implements
    AdminRepository,
    UserProvider
{

    public function boot()
    {
        $this->pushCriteria(new AdminCriteria);
    }

    public function model()
    {
        return Admin::class;
    }

    public function createProfile(array $attributes, $adminId)
    {
        $customer = $this->skipCriteria()->find($adminId);

        return $customer->profile()->create($attributes);
    }

    public function updateProfile(array $attributes, $adminId)
    {
        $customer = $this->find($adminId);

        return $customer->profile()->update($attributes);
    }

}
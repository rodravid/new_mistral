<?php

namespace Vinci\Domain\Auth;

use Illuminate\Contracts\Auth\UserProvider;
use Vinci\Domain\User\UserRepository;

abstract class AuthUserProvider implements UserProvider
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

}
<?php

namespace Vinci\App\Core\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Vinci\App\Core\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Doctrine\ORM\EntityManagerInterface;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->middleware('guest');
    }

    protected function resetPassword($user, $password)
    {
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        Auth::guard($this->getGuard())->login($user);
    }

}

<?php

namespace Vinci\App\Cms\Http\Auth;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Cms\Http\User\Presenters\DefaultUserPresenter;
use Vinci\App\Core\Http\Controllers\Auth\PasswordController as BaseAuthController;

class PasswordController extends BaseAuthController
{

    protected $guard = 'cms';

    protected $broker = 'admins';

    protected $linkRequestView = 'cms::auth.passwords.email';

    protected $resetView = 'cms::auth.passwords.reset';

    protected $redirectPath = '/cms/login';

    protected $user;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->user = Auth::guard('cms')->user();
        view()->share('loggedUser', new DefaultUserPresenter($this->user));
    }

    public function help()
    {
        return $this->view('cms::auth.passwords.help');
    }

}
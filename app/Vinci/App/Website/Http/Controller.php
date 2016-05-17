<?php

namespace Vinci\App\Website\Http;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Core\Http\Controllers\Controller as BaseController;
use Vinci\App\Website\Http\Customer\Presenters\CustomerPresenter;

class Controller extends BaseController
{

    protected $viewNamespace = 'website';

    protected $user;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->shareLoggedUser();
    }

    protected function shareLoggedUser()
    {
        $this->user = Auth::guard('website')->user();

        if ($this->user) {
            view()->share('loggedUser', new CustomerPresenter($this->user));
        }
    }

}
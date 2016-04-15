<?php

namespace Vinci\App\Cms\Http;

use Auth;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Cms\Http\User\Presenters\DefaultUserPresenter;
use Vinci\App\Core\Http\Controllers\Controller as BaseController;
use Vinci\Domain\ACL\ACLService;

class Controller extends BaseController
{

    protected $viewNamespace = 'cms';

    protected $user;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em);

        $this->user = Auth::guard('cms')->user();
        view()->share('loggedUser', new DefaultUserPresenter($this->user));
    }

    protected function getEditRouteName()
    {
        return 'cms.' . app(ACLService::class)->getCurrentModuleName() . '.edit';
    }

    protected function getListRouteName()
    {
        return 'cms.' . app(ACLService::class)->getCurrentModuleName() . '.list';
    }

}
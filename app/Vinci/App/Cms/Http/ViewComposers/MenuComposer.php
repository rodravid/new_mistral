<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\Domain\ACL\Module\ModuleRepository;

class MenuComposer
{

    private $moduleRepository;

    public function __construct(ModuleRepository $moduleRepository)
    {
        $this->moduleRepository = $moduleRepository;
    }

    public function compose(View $view)
    {
        $modules = $this->moduleRepository->findModulesForAdminUser(cmsUser());

        $view->with('modules', $modules);
    }

}
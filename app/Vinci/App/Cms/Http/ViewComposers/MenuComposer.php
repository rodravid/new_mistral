<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\Routing\Route;
use Illuminate\View\View;
use Vinci\Domain\ACL\ACLService;

class MenuComposer
{
    private $ACLService;

    private $route;

    public function __construct(ACLService $ACLService, Route $route)
    {
        $this->ACLService = $ACLService;
        $this->route = $route;
    }

    public function compose(View $view)
    {
        $modules = $this->ACLService->buildModulesTreeHtmlForUser(cmsUser(), $this->getOptions());

        $view->with('modules', $modules);
    }

    protected function getOptions()
    {
        return [
            'decorate' => true,
            'rootOpen' => function($tree) {
                if ($tree[0]['lvl'] > 0) {
                    return '<ul class="treeview-menu">';
                }
            },
            'rootClose' => function($tree) {
                if ($tree[0]['lvl'] > 0) {
                    return '</ul>';
                }
            },
            'childOpen' => function($module) {

                if (preg_match('/' . $module['name'] . '/', $this->route->getName())) {
                    return '<li class="active">';
                }

                return '<li>';
            },
            'childClose' => '</li>',
            'nodeDecorator' => function($node) {

                $hasChildrens = count($node['__children']) > 0 ? true : false;

                $href = $hasChildrens ? 'href="javascript:void(0);"' : 'href="' . $node['url'] . '"';

                $chevron = $hasChildrens ? ' <i class="fa fa-angle-left pull-right"></i>' : '';

                return '<a ' . $href . '><i class="' . $node['icon'] . '"></i> <span>' . $node['title'] . '</span>' . $chevron . '</a>';
            }
        ];
    }

}
<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\Domain\ACL\ACLService;

class MenuComposer
{
    private $ACLService;

    public function __construct(ACLService $ACLService)
    {
        $this->ACLService = $ACLService;
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
            'childOpen' => '<li>',
            'childClose' => '</li>',
            'nodeDecorator' => function($node) {

                $hasChildrens = count($node['__children']) > 0 ? true : false;

                $href = $hasChildrens ? '' : 'href="' . $node['url'] . '"';

                $chevron = $hasChildrens ? ' <i class="fa fa-angle-left pull-right"></i>' : '';

                return '<a ' . $href . '><i class="' . $node['icon'] . '"></i> <span>' . $node['title'] . '</span>' . $chevron . '</a>';
            }
        ];
    }

}
<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\Domain\Template\TemplateRepository;

class TemplateViewComposer
{

    protected $templateRepository;

    public function __construct(TemplateRepository $templateRepository)
    {
        $this->templateRepository = $templateRepository;
    }

    public function compose(View $view)
    {
        $view->with('templates', $this->getTemplates());
    }

    private function getTemplates()
    {
        $templates = [];

        foreach ($this->templateRepository->getAll() as $template) {
            $templates[$template->getId()] = $template->getTitle();
        }

        return $templates;
    }

}
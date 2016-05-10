<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\Domain\Grape\GrapeRepository;

class ProductViewComposer
{

    protected $grapeRepository;

    public function __construct(GrapeRepository $grapeRepository)
    {
        $this->grapeRepository = $grapeRepository;
    }

    public function compose(View $view)
    {
        $view->with('grapes', $this->getGrapes());
        $view->with('discountTypes', $this->getDiscountTypes());
    }

    protected function getDiscountTypes()
    {
        return [
            '' => 'Nenhum',
            'percent' => 'Porcentagem',
            'fixed' => 'Fixo',
            'exchange-rate' => 'Taxa de câmbio'
        ];
    }

    protected function getGrapes()
    {
        $g = $this->grapeRepository->getAll();

        $grapes = [];

        foreach ($g as $grape) {
            $grapes[$grape->getId()] = $grape->getName();
        }

        return $grapes;
    }

}
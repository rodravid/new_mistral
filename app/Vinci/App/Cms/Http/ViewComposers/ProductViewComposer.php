<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\Domain\Grape\GrapeRepository;
use Vinci\Domain\Product\Wine\Repositories\CriticalAcclaimsRepository;

class ProductViewComposer
{

    protected $grapeRepository;

    protected $criticalAcclaimsRepository;

    public function __construct(GrapeRepository $grapeRepository, CriticalAcclaimsRepository $criticalAcclaimsRepository)
    {
        $this->grapeRepository = $grapeRepository;
        $this->criticalAcclaimsRepository = $criticalAcclaimsRepository;
    }

    public function compose(View $view)
    {
        $view->with('grapes', $this->getGrapes());
        $view->with('discountTypes', $this->getDiscountTypes());
        $view->with('wineCriticalAcclaims', $this->getCriticalAcclaims());
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

    protected function getCriticalAcclaims()
    {
        $wineCriticalAcclaims = $this->criticalAcclaimsRepository->getAll();


        $dataReturn = array();

        foreach ($wineCriticalAcclaims as $data) {
            $dataReturn[$data->id] = $data->title;
        }

        return $dataReturn;
    }

}
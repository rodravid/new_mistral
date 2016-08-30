<?php

namespace Vinci\App\Website\Http\ViewComposers;

use Cache;
use Illuminate\View\View;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Http\Showcase\Presenters\ShowcasePresenter;
use Vinci\Domain\Showcase\ShowcaseRepository;

class WeekHighlightsComposer
{

    protected $showcaseRepository;

    protected $presenter;

    public function __construct(ShowcaseRepository $showcaseRepository, Presenter $presenter)
    {
        $this->showcaseRepository = $showcaseRepository;
        $this->presenter = $presenter;
    }

    public function compose(View $view)
    {

        $showcases = Cache::remember('week-highlights-showcases', 5, function() {
            return $this->showcaseRepository->lists('week-highlights-showcases');
        });

        if (! empty($showcases)) {

            $showcase = $this->presenter->model($showcases[0], ShowcasePresenter::class);
            $view->with('showcase', $showcase);
        }
    }

}
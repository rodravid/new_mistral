<?php

namespace Vinci\App\Website\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\App\Website\Http\Showcase\Presenters\ShowcasePresenter;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Showcase\ShowcaseRepository;

class WeekHighlightsComposer
{

    protected $showcaseRepository;

    protected $presenter;

    protected $productRepository;

    public function __construct(ShowcaseRepository $showcaseRepository, ProductRepository $productRepository, Presenter $presenter)
    {
        $this->showcaseRepository = $showcaseRepository;
        $this->presenter = $presenter;
        $this->productRepository = $productRepository;
    }

    public function compose(View $view)
    {

        $showcases = $this->showcaseRepository->lists('week-highlights-showcases');

        if (! empty($showcases)) {
            $showcase = $this->presenter->model($showcases[0], ShowcasePresenter::class);

            $products = $this->productRepository->getProductsByShowcase($showcase->getId());

            $products = $this->presenter->paginator($products, ProductPresenter::class);

            $view->with('weekHighlightsShowcase', $showcase);
            $view->with('weekHighlightsProducts', $products);
        }
    }

}
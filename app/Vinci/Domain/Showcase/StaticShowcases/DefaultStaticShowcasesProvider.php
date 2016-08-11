<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use Vinci\App\Website\Http\Showcase\Presenters\ShowcasePresenter;
use Vinci\Domain\Showcase\StaticShowcases\ByPrices\AcimaDe500;
use Vinci\Domain\Showcase\StaticShowcases\ByPrices\Ate60;
use Vinci\Domain\Showcase\StaticShowcases\ByPrices\De100a170;
use Vinci\Domain\Showcase\StaticShowcases\ByPrices\De170a270;
use Vinci\Domain\Showcase\StaticShowcases\ByPrices\De270a500;
use Vinci\Domain\Showcase\StaticShowcases\ByPrices\De60a100;

class DefaultStaticShowcasesProvider implements StaticShowcasesProvider
{
    protected $showcases = [
        HalfBottle::class,
        ScoredWines::class,
        RobertParker::class,
        WineSpectator::class,
        NinetyPoints::class,
        NinetyFivePoints::class,
        Ate60::class,
        De60a100::class,
        De100a170::class,
        De170a270::class,
        De270a500::class,
        AcimaDe500::class,
    ];

    protected $instances = [];

    public function __construct()
    {
        $this->instances = collect();
    }

    public function getShowcases()
    {
        if ($this->instances->count() != count($this->showcases)) {

            foreach ($this->showcases as $key => $showcase) {
                if (! $this->instances->has($key)) {
                    $this->instances->put($key, present()->model(app($showcase), ShowcasePresenter::class));
                }
            }
        }

        return $this->instances;
    }

    public function getShowcaseBySlug($slug)
    {
        return $this->getShowcases()->filter(function($showcase) use ($slug) {
            return $slug == $showcase->getSlug();
        })->first();
    }

}
<?php

namespace Vinci\Domain\Showcase\StaticShowcases;

use Vinci\App\Website\Http\Showcase\Presenters\ShowcasePresenter;

class DefaultStaticShowcasesProvider implements StaticShowcasesProvider
{
    protected $showcases = [
        HalfBottle::class,
        ScoredWines::class
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
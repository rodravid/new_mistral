<?php

namespace Vinci\App\Website\Http\Taxonomy;

use Vinci\App\Website\Http\Search\SearchController;

class BaseTaxonomyController extends SearchController
{

    protected function getSearchUrlPath($request)
    {
        return $request->get('slug');
    }

}
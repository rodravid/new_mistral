<?php

namespace Vinci\App\Website\Http\Search;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Search\Product\ProductIndexerService;
use Vinci\Domain\Search\Product\ProductSearchService;

class SearchController extends Controller
{

    protected $searchService;

    protected $indexerService;

    public function __construct(EntityManagerInterface $em, ProductSearchService $searchService, ProductIndexerService $indexerService)
    {
        parent::__construct($em);

        $this->searchService = $searchService;
        $this->indexerService = $indexerService;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('termo');

        $result = $this->searchService->search($keyword);

        $result->getItems()->setPath('busca');
        $result->getItems()->appends($this->getAppends($request));

        return $this->view('search.index', compact('result'));
    }

    protected function getFilters($request)
    {




    }

    private function getAppends($request)
    {
        return [
            'termo' => $request->get('termo')
        ];

    }

}
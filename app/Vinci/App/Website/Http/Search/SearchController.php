<?php

namespace Vinci\App\Website\Http\Search;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Search\Product\ProductSearchService;

class SearchController extends Controller
{

    protected $searchService;

    public function __construct(EntityManagerInterface $em, ProductSearchService $searchService)
    {
        parent::__construct($em);

        $this->searchService = $searchService;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('termo');
        $filters = $this->getFilters($request);

        list($limit, $start) = $this->getLimitStart($request);

        $result = $this->searchService->search($keyword, $filters, $limit, $start);

        if ($result->hasItems()) {
            $result->getItems()->setPath('busca');
            $result->getItems()->appends($this->getAppends($request));
        }

        return $this->view('search.index', compact('result', 'filters'));
    }

    protected function getFilters(Request $request)
    {
        $filters = [];

        if ($request->has('pais')) {
            $filters['pais'] = $request->get('pais');
        }

        if ($request->has('regiao')) {
            $filters['regiao'] = $request->get('regiao');
        }

        if ($request->has('produtor')) {
            $filters['produtor'] = $request->get('produtor');
        }

        return $filters;
    }

    protected function getAppends(Request $request)
    {
        $appends = [];

        if ($request->has('termo')) {
            $appends['termo'] = $request->get('termo');
        }

        if ($request->has('max')) {
            $appends['max'] = intval($request->get('max'));
        }

        return array_merge($appends, $this->getFilters($request));
    }

    protected function getLimitStart(Request $request)
    {
        $page = intval($request->get('page', 1));
        $limit = intval($request->get('max', 15));

        $start = $page * $limit - $limit;

        return [$limit, $start];
    }

}
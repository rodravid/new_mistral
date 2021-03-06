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
        $result = $this->search($request);

        return $this->view('search.index', compact('result'));
    }

    protected function search($request, array $appendFilters = [])
    {
        $keyword = $request->get('termo');

        $filters = $this->getFilters($request);

        $filters = array_merge_recursive($filters, $appendFilters);

        $sort = $this->getSort($request);

        list($limit, $start) = $this->getLimitStart($request);

        $result = $this->searchService->search($keyword, $filters, $limit, $start, $sort);

        if ($result->hasItems()) {
            $result->getItems()->setPath($this->getSearchUrlPath($request));
            $result->getItems()->appends($this->getAppends($request));
        }

        $result->setVisibleFilters(['pais', 'regiao', 'produtor', 'tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco']);
        $result->setSelectedFilters($this->getSelectedFilters($request));

        return $result;
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

        if ($request->has('tamanho')) {
            $filters['tamanho'] = $request->get('tamanho');
        }

        if ($request->has('preco')) {
            $filters['preco'] = $request->get('preco');
        }

        if ($request->has('tipo-de-uva')) {
            $filters['tipo-de-uva'] = $request->get('tipo-de-uva');
        }

        if ($request->has('tipo-de-vinho')) {
            $filters['tipo-de-vinho'] = $request->get('tipo-de-vinho');
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

        if ($request->has('ordem')) {
            $appends['ordem'] = intval($request->get('ordem'));
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

    protected function getSelectedFilters($request)
    {
        return $this->getFilters($request);
    }

    protected function getSearchUrlPath($request)
    {
        return '';
    }

    protected function getSort($request)
    {
        return $request->get('ordem', 1);
    }

    public function suggest(Request $request)
    {

        $keyword = $request->get('q');

        if (empty($keyword)) {
            return [];
        }

        $result = $this->searchService->search($request->get('q'));

        $suggester = $result->getSuggester('title-suggester');

        $data = [];
        foreach ($suggester->getOptions() as $option) {

            $data[] = [
                'title' => $option->getText(),
                'producer' => $option->getPayload('producer'),
                'country' => $option->getPayload('country'),
                'url' => $option->getPayload('url')
            ];

        }

        return $data;
    }

}
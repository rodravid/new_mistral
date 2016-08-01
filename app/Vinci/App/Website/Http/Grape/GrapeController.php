<?php

namespace Vinci\App\Website\Http\Grape;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Grape\GrapeRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class GrapeController extends BaseTaxonomyController
{

    private $grapeRepository;

    public function __construct(
        EntityManagerInterface $em,
        GrapeRepository $grapeRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->grapeRepository = $grapeRepository;
    }

    public function show($slug, Request $request)
    {
        $grape = $this->getGrape($slug);

        $filters = [
            'filters' => [
                'tipo-de-uva' => [$grape->getName()]
            ]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['pais', 'regiao', 'produtor', 'tipo-de-vinho', 'tamanho', 'preco']);

        return $this->view('grape.index', compact('grape', 'result'));
    }

    protected function getGrape($slug)
    {
        $grape = $this->grapeRepository->getOneBySlug($slug);

        $grape = $this->presenter->model($grape, GrapePresenter::class);

        return $grape;
    }

}
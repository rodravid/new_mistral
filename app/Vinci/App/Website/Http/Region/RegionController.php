<?php

namespace Vinci\App\Website\Http\Region;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Region\RegionRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class RegionController extends BaseTaxonomyController
{

    private $regionRepository;

    public function __construct(
        EntityManagerInterface $em,
        RegionRepository $regionRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->regionRepository = $regionRepository;
    }

    public function show($slug, Request $request)
    {
        $region = $this->getRegion($slug);

        $filters = [
            'regiao' => [$region->getName()]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['produtor', 'tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco']);

        return $this->view('region.index', compact('region', 'result'));
    }

    protected function getRegion($slug)
    {
        $country = $this->regionRepository->getOneBySlug($slug);

        $country = $this->presenter->model($country, RegionPresenter::class);

        return $country;
    }

}
<?php

namespace Vinci\App\Website\Http\Country;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Common\TaxonomyCollection;
use Vinci\Domain\Country\CountryRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class CountryController extends BaseTaxonomyController
{

    private $countryRepository;

    public function __construct(
        EntityManagerInterface $em,
        CountryRepository $countryRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->countryRepository = $countryRepository;
    }

    public function show($slug, Request $request)
    {
        $country = $this->getCountry($slug);

        $filters = [
            'pais' => [$country->getName()]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['regiao', 'produtor', 'tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco']);

        return $this->view('country.index', compact('country', 'result'));
    }

    public function index(Request $request)
    {
        $countries = new TaxonomyCollection($this->countryRepository->getAll());

        $countries = $countries->filter(function ($country) {
            return ! in_array($country->getName(), ['Acessórios', 'Embalagens']);
        });

        $pageDescription = 'São mais de 1000 rótulos de vinhos de 15 países diferentes, 
                            mais de 150 produtores exclusivos do mais alto nível, 
                            entre as maiores estrelas de suas regiões!';

        return $this->view('layouts.pages.list')
                    ->with([
                        'metaTitle' => 'Os melhores vinhos do mundo de cada país - Vinci',
                        'metaDescription' => $pageDescription,
                        'resources' => $countries,
                        'resourceType' => 'country',
                        'pageTitle' => 'Vinhos por país',
                        'pageDescription' => $pageDescription,
                        'template' => 'template1',
                        'imageTitle' => 'bg-pais.jpg'
                    ]);
    }

    protected function getCountry($slug)
    {
        $country = $this->countryRepository->getOneBySlug($slug);

        $country = $this->presenter->model($country, CountryPresenter::class);

        return $country;
    }

}
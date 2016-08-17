<?php

namespace Vinci\App\Website\Http\Producer;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
use Vinci\Domain\Common\TaxonomyCollection;
use Vinci\Domain\Producer\ProducerRepository;
use Vinci\Domain\Search\Product\ProductSearchService;

class ProducerController extends BaseTaxonomyController
{

    private $producerRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProducerRepository $producerRepository,
        ProductSearchService $searchService
    ) {
        parent::__construct($em, $searchService);

        $this->producerRepository = $producerRepository;
    }

    public function show($slug, Request $request)
    {
        $producer = $this->getProducer($slug);

        $filters = [
            'produtor' => [$producer->getName()]
        ];

        $result = $this->search($request, $filters);

        $result->setVisibleFilters(['tipo-de-uva', 'tipo-de-vinho', 'tamanho', 'preco']);

        return $this->view('producer.index', compact('producer', 'result'));
    }

    public function index(Request $request)
    {
        $producers = new TaxonomyCollection($this->producerRepository->getAll());

        $pageDescription = 'Os mais prestigiados produtores de vinho da 
                            atualidade no portfólio da Vinci oferecendo 
                            os melhores vinhos das grandes regiões vinícolas 
                            do mundo. Veja!';

        return $this->view('layouts.pages.list')
                    ->with([
                        'metaTitle' => 'Os maiores produtores de vinho da atualidade - Vinci',
                        'metaDescription' => $pageDescription,
                        'resources' => $producers,
                        'resourceType' => 'producer',
                        'pageTitle' => 'Vinhos por produtor',
                        'pageDescription' => $pageDescription,
                        'template' => 'template3',
                        'imageTitle' => 'bg-produtor.png'
                    ]);
    }

    protected function getProducer($slug)
    {
        $producer = $this->producerRepository->getOneBySlug($slug);

        $producer = $this->presenter->model($producer, ProducerPresenter::class);

        return $producer;
    }

}
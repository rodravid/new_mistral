<?php

namespace Vinci\App\Website\Http\Producer;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Vinci\App\Website\Http\Taxonomy\BaseTaxonomyController;
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

    protected function getProducer($slug)
    {
        $producer = $this->producerRepository->getOneBySlug($slug);

        $producer = $this->presenter->model($producer, ProducerPresenter::class);

        return $producer;
    }

}
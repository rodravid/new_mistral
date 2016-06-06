<?php

namespace Vinci\App\Website\Http\Producer;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Producer\ProducerRepository;

class ProducerController extends Controller
{

    private $producerRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProducerRepository $producerRepository
    ) {
        parent::__construct($em);

        $this->producerRepository = $producerRepository;
    }

    public function show($slug)
    {
        $producer = $this->producerRepository->getOneBySlug($slug);

        $producer = $this->presenter->model($producer, ProducerPresenter::class);

        return $this->view('producer.index', compact('producer'));
    }

}
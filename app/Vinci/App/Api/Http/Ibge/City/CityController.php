<?php

namespace Vinci\App\Api\Http\Ibge\City;

use Doctrine\ORM\EntityManagerInterface;
use Response;
use Vinci\App\Api\Http\Controller;
use Vinci\App\Api\Http\Ibge\City\Transformers\CityTransformer;
use Vinci\Domain\Address\City\CityRepository;

class CityController extends Controller
{

    private $repository;

    public function __construct(EntityManagerInterface $em, CityRepository $repository)
    {
        parent::__construct($em);

        $this->repository = $repository;
    }

    public function getByState($state)
    {
        $cities = $this->repository->getByState($state);

        $cities = fractal()
            ->collection($cities)
            ->transformWith(new CityTransformer());

        return Response::json($cities->toArray());
    }

}
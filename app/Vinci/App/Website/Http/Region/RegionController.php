<?php

namespace Vinci\App\Website\Http\Region;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Region\RegionRepository;

class RegionController extends Controller
{

    private $regionRepository;

    public function __construct(
        EntityManagerInterface $em,
        RegionRepository $regionRepository
    ) {
        parent::__construct($em);

        $this->regionRepository = $regionRepository;
    }

    public function show($slug)
    {
        $region = $this->regionRepository->getOneBySlug($slug);

        $region = $this->presenter->model($region, RegionPresenter::class);

        return $this->view('region.index', compact('region'));
    }

}
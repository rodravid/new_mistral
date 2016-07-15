<?php

namespace Vinci\App\Cms\Http\ViewComposers;

use Illuminate\View\View;
use Vinci\Domain\Country\CountryRepository;
use Vinci\Domain\Producer\ProducerRepository;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\ProductType\ProductTypeRepository;
use Vinci\Domain\Region\RegionRepository;

class ProductFiltersComposer
{

    private $productRepository;

    private $countryRepository;

    private $regionRepository;

    private $producerRepository;

    private $productTypeRepository;

    public function __construct(
        ProductRepository $productRepository,
        CountryRepository $countryRepository,
        RegionRepository $regionRepository,
        ProducerRepository $producerRepository,
        ProductTypeRepository $productTypeRepository
    ) {
        $this->productRepository = $productRepository;
        $this->countryRepository = $countryRepository;
        $this->regionRepository = $regionRepository;
        $this->producerRepository = $producerRepository;
        $this->productTypeRepository = $productTypeRepository;
    }

    public function compose(View $view)
    {
        $view->with('products', $this->productRepository->getAllValidForSelectArray());
        $view->with('countries', $this->countryRepository->getAllValidForSelectArray());
        $view->with('regions', $this->regionRepository->getAllValidForSelectArray());
        $view->with('producers', $this->producerRepository->getAllValidForSelectArray());
        $view->with('productTypes', $this->productTypeRepository->getAllValidForSelectArray());
    }

}
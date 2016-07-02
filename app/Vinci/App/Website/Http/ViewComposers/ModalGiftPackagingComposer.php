<?php

namespace Vinci\App\Website\Http\ViewComposers;


use Illuminate\View\View;
use Vinci\App\Core\Services\Presenter\Presenter;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\ProductType\ProductType;

class ModalGiftPackagingComposer
{

    protected $productRepository;

    private $presenter;

    public function __construct(ProductRepository $productRepository, Presenter $presenter)
    {

        $this->productRepository = $productRepository;

        $this->presenter = $presenter;
    }

    public function compose(View $view)
    {
        $giftPackages = $this->productRepository->getAvailableProductsFromTypes([ProductType::TYPE_PACKING]);

        $view->with('giftPackages', $this->presenter->collection($giftPackages, ProductPresenter::class));

    }
}
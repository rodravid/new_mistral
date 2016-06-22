<?php

namespace Vinci\Domain\ProductNotify\Services;

use Vinci\Domain\Product\Notify\Repositories\ProductNotifyRepository;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\ProductNotify\Validators\ProductNotifyValidator;
use Vinci\Domain\Core\Validation\ValidationTrait;

class ProductNotifyService
{
    use ValidationTrait;
    
    private $validator;

    private $productNotifyrepository;

    private $productRepository;

    public function __construct(
        ProductNotifyRepository $productNotifyRepository,
        ProductNotifyValidator $productNotifyValidator,
        ProductRepository $productRepository
    ) {
        $this->productNotifyrepository = $productNotifyRepository;
        $this->validator = $productNotifyValidator;
        $this->productRepository = $productRepository;
    }

    public function registerNotify($data)
    {
        $this->validator->with($data)->passesOrFail();

        $productNotify = $this->productNotifyrepository->hasntRegisteredYet($data);

        if (empty($productNotify)) {
            $data['product'] = $this->productRepository->find($data['product']);

            $this->repository->registerNotify($data);
            return true;
        }

        $productNotify->setStatus(0);

        $this->productNotifyrepository->persistAndFlush($productNotify);
    }

}
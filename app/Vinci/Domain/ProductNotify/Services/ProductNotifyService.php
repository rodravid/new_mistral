<?php

namespace Vinci\Domain\ProductNotify\Services;

use Vinci\Domain\Product\Notify\Repositories\ProductNotifyRepository;
use Vinci\Domain\ProductNotify\Validators\ProductNotifyValidator;
use Vinci\Domain\Core\Validation\ValidationTrait;

class ProductNotifyService
{
    use ValidationTrait;
    
    private $validator;

    private $repository;

    public function __construct(
        ProductNotifyRepository $productNotifyRepository,
        ProductNotifyValidator $productNotifyValidator
    ) {
        $this->repository = $productNotifyRepository;
        $this->validator = $productNotifyValidator;
    }

    public function registerNotify($data)
    {
        $this->validator->with($data)->passesOrFail();

        $productNotify = $this->repository->hasntRegisteredYet($data);

        $this->repository->registerNotify($data);
    }

}
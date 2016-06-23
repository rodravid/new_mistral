<?php

namespace Vinci\Domain\ProductNotify\Services;

use Vinci\Domain\Common\Status;
use Vinci\Domain\Product\Notify\Repositories\ProductNotifyRepository;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\ProductNotify\Validators\ProductNotifyValidator;
use Vinci\Domain\Core\Validation\ValidationTrait;

class ProductNotifyService
{
    use ValidationTrait;
    
    private $validator;

    private $productNotifyRepository;

    private $productRepository;

    public function __construct(
        ProductNotifyRepository $productNotifyRepository,
        ProductNotifyValidator $productNotifyValidator,
        ProductRepository $productRepository
    ) {
        $this->productNotifyRepository = $productNotifyRepository;
        $this->validator = $productNotifyValidator;
        $this->productRepository = $productRepository;
    }

    public function registerNotify($data)
    {
        $this->validator->with($data)->passesOrFail();

        $productNotify = $this->productNotifyRepository-> findOneByEmailAndProductId($data);

        if (empty($productNotify)) {
            $data['product'] = $this->productRepository->find($data['product']);

            $this->productNotifyRepository->registerNotify($data);
            return true;
        }

        $productNotify->setStatus(Status::EMAIL_NOT_SENDED);

        $this->productNotifyRepository->save($productNotify);
    }

}
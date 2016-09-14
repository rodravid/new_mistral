<?php

namespace Vinci\Domain\Product\Services;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\File\Mapping\DefaultFileMapping;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Domain\Product\Events\ProductWasUpdated;
use Vinci\Domain\Product\Factories\Contracts\ProductFactory;
use Vinci\Domain\Product\Image\ProductImagePathBuilder;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\ProductVariantInterface;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Validators\ProductValidator;
use Intervention\Image\Facades\Image as InterventionImage;
use Vinci\Infrastructure\Storage\StorageService;
use Vinci\Domain\Image\ImageRepository;

class ProductManagementService
{

    private $entityManager;

    private $repository;

    private $validator;

    private $imageService;

    private $productFactory;

    private $eventDispatcher;

    private $storageService;

    private $imageRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $repository,
        ProductValidator $validator,
        ProductImageService $imageService,
        ProductFactory $productFactory,
        Dispatcher $eventDispatcher,
        StorageService $storageService,
        ImageRepository $imageRepository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->imageService = $imageService;
        $this->productFactory = $productFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->storageService = $storageService;
        $this->imageRepository = $imageRepository;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->saveProduct($data, function($data) {

            $product = $this->productFactory->make($data);

            return $product;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveProduct($data, function($data) use ($id) {

            $product = $this->repository->find($id);

            $this->productFactory->override($product, $data);

            $event = new ProductWasUpdated($product);

            if (isset($data['user'])) {
                $event->setRaisedByUserInteration(true);
            }

            $product->raise($event);

            return $product;
        });
    }

    protected function saveProduct($data, Closure $method)
    {
        try {

            $this->entityManager->beginTransaction();

            $product = $method($data);

            $this->repository->save($product);

            $this->saveImages($data, $product);

            foreach ($product->releaseEvents() as $event) {
                $this->eventDispatcher->fire($event);
            }

            $this->entityManager->commit();

            return $product;

        } catch (Exception $e) {

            $this->entityManager->rollback();

            throw $e;
        }
    }

    public function changePrice(ProductVariantInterface $variant, array $newPrice)
    {
        $currentPrice = $variant->getPrice();
        $newPrice = $newPrice[0];

        if (! empty($price = array_get($newPrice, 'price'))) {
            $currentPrice->setPrice($price);
        }

        if (! empty($currency = array_get($newPrice, 'currency_amount'))) {
            $currentPrice->setCurrencyAmount($currency);
        }

        if (! empty($ipi = array_get($newPrice, 'aliquot_ipi'))) {
            $currentPrice->setAliquotIpi($ipi);
        }

        if (! empty($discountType = array_get($newPrice, 'discount_type'))) {
            $currentPrice->setDiscountType($discountType);
        }

        if (! empty($discountValue = array_get($newPrice, 'discount_value'))) {
            $currentPrice->setDiscountValue($discountType);
        }

        $this->entityManager->persist($currentPrice);
        $this->entityManager->flush();
    }

    protected function saveImages($data, Product $product)
    {
        if (isset($data['photo']) && ! empty($file = $data['photo'])) {

            $photo = Image::makeFromUpload($file);

            $filePath = $file->getPathname();

            $pathBuilder = new ProductImagePathBuilder($product);

            $mapping = (new DefaultFileMapping())->withPathBuilder($pathBuilder);

            $pathData = $pathBuilder->build($mapping, $file);

            $photo->setPath($pathData->getPath());
            $photo->setName($pathData->getFilename());

            $photo->addVersion(ImageVersion::ORIGINAL, clone $photo);

            $interventionImage = InterventionImage::make($filePath);

            $interventionImage->resize(null, 470, function($constraint) {
                $constraint->aspectRatio();
            });

            $interventionImage->save(storage_path('app/tmp/medium.png'));
            $fileMediumUpload = new UploadedFile(storage_path('app/tmp/medium.png'), 'medium.png');

            $imageMedium = clone $photo;
            $imageMedium->setUploadedFile($fileMediumUpload);
            $imageMedium->setName($pathBuilder->build($mapping, $fileMediumUpload)->getFilename());
            $imageMedium->setWidth($interventionImage->getWidth());
            $imageMedium->setHeight($interventionImage->getHeight());
            $imageMedium->setSize($interventionImage->filesize());

            $photo->addVersion(ImageVersion::MEDIUM, $imageMedium);

            $interventionImage->resize(100, null, function($constraint) {
                $constraint->aspectRatio();
            });

            $interventionImage->save(storage_path('app/tmp/small.png'));
            $fileSmallUpload = new UploadedFile(storage_path('app/tmp/small.png'), 'small.png');

            $imageSmall = clone $photo;
            $imageSmall->setUploadedFile($fileSmallUpload);
            $imageSmall->setName($pathBuilder->build($mapping, $fileSmallUpload)->getFilename());
            $imageSmall->setWidth($interventionImage->getWidth());
            $imageSmall->setHeight($interventionImage->getHeight());
            $imageSmall->setSize($interventionImage->filesize());
            $photo->addVersion(ImageVersion::SMALL, $imageSmall);

            //Operacoes database
            $this->storageService->storeImage($photo);
            $this->imageRepository->save($photo);
            $product->addImage($photo, ImageVersion::PHOTO);

            $this->repository->save($product);

        }
    }

}
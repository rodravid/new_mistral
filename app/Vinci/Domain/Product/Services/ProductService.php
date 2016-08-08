<?php

namespace Vinci\Domain\Product\Services;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\UploadedFile;
use Vinci\App\Website\Http\Product\Presenter\ProductPresenter;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Validators\ProductValidator;
use Vinci\Infrastructure\Storage\StorageService;

class ProductService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $storage;

    private $imageRepository;

    private $aclService;
    /**
     * @var Repository
     */
    private $cache;

    public function __construct(
        EntityManagerInterface $entityManager,
        ProductRepository $repository,
        ProductValidator $validator,
        StorageService $storage,
        ImageRepository $imageRepository,
        ACLService $aclService,
        Repository $cache
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->storage = $storage;
        $this->imageRepository = $imageRepository;
        $this->aclService = $aclService;
        $this->cache = $cache;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->saveProduct($data, function($data) {

            $highlight = new Product;
            $highlight->setScheduleFieldsFromArray($data);
            $highlight->fill($data);

            return $highlight;

        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveProduct($data, function($data) use ($id) {

            $highlight = $this->repository->find($id);
            $highlight->setScheduleFieldsFromArray($data);
            $highlight->fill($data);

            return $highlight;
        });
    }

    public function storeImage(Product $highlight, UploadedFile $image)
    {
        $this->entityManager->getConnection()->beginTransaction();

        try {

            $image = Image::makeFromUpload($image, $highlight->getImagesUploadPath());

            $this->storage->storeImage($image);

            $this->imageRepository->save($image);

            $this->entityManager->getConnection()->commit();

            return $image;

        } catch (Exception $e) {

            $this->entityManager->getConnection()->rollBack();
            throw $e;
        }
    }

    public function removeImage(Image $image, Product $highlight)
    {
        $highlight->removeImage($image);
        $this->storage->deleteImage($image);

        $this->entityManager->persist($highlight);
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

    protected function saveProduct($data, Closure $method)
    {
        $highlight = $method($data);

        $highlight->setType($this->aclService->getCurrentModuleName());

        $this->repository->save($highlight);

        if (! empty($imageDesktop = $data['image_desktop'])) {
            $image = $this->storeImage($highlight, $imageDesktop);
            $highlight->addImage($image, ImageVersion::DESKTOP);
        }

        if (! empty($imageMobile = $data['image_mobile'])) {
            $image = $this->storeImage($highlight, $imageMobile);
            $highlight->addImage($image, ImageVersion::MOBILE);
        }

        $this->repository->save($highlight);

        return $highlight;
    }

    public function makeMenuCardHtml($product, $title, $template)
    {
        return $this->cache->remember('product-card-menu-' . $product, 5, function() use ($product, $title, $template) {

            $product = $this->repository->find($product);

            if (! $product) {
                return '';
            }

            return view('website::layouts.partials.product.cards.menu', [
                'title' => $title,
                'product' => present()->model($product, ProductPresenter::class),
                'template' => $template
            ])->render();
        });
    }

}
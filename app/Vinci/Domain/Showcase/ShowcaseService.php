<?php

namespace Vinci\Domain\Showcase;

use Cache;
use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\UploadedFile;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageService;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Template\Template;
use Vinci\Infrastructure\Storage\StorageService;

class ShowcaseService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $aclService;

    private $imageService;

    private $storage;

    public function __construct(
        EntityManagerInterface $entityManager,
        ShowcaseRepository $repository,
        ShowcaseValidator $validator,
        ImageService $imageService,
        StorageService $storage,
        ACLService $aclService
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->aclService = $aclService;
        $this->imageService = $imageService;
        $this->storage = $storage;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->saveShowcase($data, function($data) {
            $showcase = new Showcase;

            $this->includeTemplate($data);
            $showcase->setScheduleFieldsFromArray($data);

            $showcase->fill($data);

            return $showcase;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveShowcase($data, function($data) use ($id) {

            $showcase = $this->repository->find($id);
            $this->includeTemplate($data);
            $showcase->setScheduleFieldsFromArray($data);
            $showcase->fill($data);

            return $showcase;
        });
    }

    protected function saveShowcase($data, Closure $method)
    {
        $showcase = $method($data);

        $showcase->setType($this->aclService->getCurrentModuleName());

        $this->repository->save($showcase);

        $this->saveImages($data, $showcase);

        return $showcase;
    }

    private function includeTemplate(&$data)
    {
        $data['template'] = $this->entityManager->getReference(Template::class, $data['template']);
    }

    public function removeItem($showcase, $item)
    {
        $showcase = $this->repository->getOneById($showcase);

        $item = $this->entityManager->getReference(ShowcaseItem::class, $item);

        $showcase->removeItem($item);

        $this->repository->save($showcase);
    }

    public function updateItemPosition($showcase, $itemId, $position)
    {
        $showcase = $this->repository->getOneById($showcase);

        foreach ($showcase->getItems() as $item) {

            if ($item->getId() == $itemId) {
                $item->setPosition(intval($position));

                $this->entityManager->persist($item);
                $this->entityManager->flush();

                Cache::tags('showcase')->flush();

                return true;

            }

        }

    }

    public function addItemWithProductId($showcase, $product)
    {
        $showcase = $this->repository->getOneById($showcase);

        $product = $this->entityManager->getReference(Product::class, $product);

        $item = new ShowcaseItem;

        $item->setProduct($product);

        $showcase->addItem($item);

        $this->repository->save($showcase);
    }

    protected function saveImages($data, Showcase $showcase)
    {
        if (isset($data['image_banner']) && ! empty($imageBanner = $data['image_banner'])) {
            $this->imageService->storeAndAttach($imageBanner, $showcase, ImageVersion::BANNER);
        }

        $this->repository->save($showcase);
    }

    public function removeImage(Image $image, Showcase $showcase)
    {
        $showcase->removeImage($image);
        $this->storage->deleteImage($image);

        $this->entityManager->persist($showcase);
        $this->entityManager->remove($image);
        $this->entityManager->flush();
    }

}
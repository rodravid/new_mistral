<?php

namespace Vinci\Domain\Showcase;

use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Core\Validation\ValidationTrait;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Template\Template;

class ShowcaseService
{
    use ValidationTrait;

    private $repository;

    private $entityManager;

    private $validator;

    private $aclService;

    public function __construct(
        EntityManagerInterface $entityManager,
        ShowcaseRepository $repository,
        ShowcaseValidator $validator,
        ACLService $aclService
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->validator = $validator;
        $this->aclService = $aclService;
    }

    public function create(array $data)
    {
        $this->validator->with($data)->passesOrFail();

        return $this->saveShowcase($data, function() {
            $showcase = new Showcase;
            return $showcase;
        });
    }

    public function update(array $data, $id)
    {
        $this->validator->with($data)->setId($id)->passesOrFail();

        return $this->saveShowcase($data, function() use ($id) {

            $showcase = $this->repository->find($id);
            return $showcase;
        });
    }

    protected function saveShowcase($data, Closure $method)
    {
        $showcase = $method($data);

        $showcase->setScheduleFieldsFromArray($data);

        $this->includeTemplate($data);

        $showcase->fill($data);

        $showcase->setType($this->aclService->getCurrentModuleName());

        $this->repository->save($showcase);

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

    public function addItemWithProductId($showcase, $product)
    {
        $showcase = $this->repository->getOneById($showcase);

        $product = $this->entityManager->getReference(Product::class, $product);

        $item = new ShowcaseItem;

        $item->setProduct($product);

        $showcase->addItem($item);

        $this->repository->save($showcase);
    }

}
<?php


namespace Vinci\Domain\Promotion;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Readers\LaravelExcelReader;
use Vinci\Domain\Image\ImageService;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\ProductInterface;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\ProductType\ProductType;
use Maatwebsite\Excel\Excel;

class PromotionService
{

    protected $entityManager;

    protected $promotionRepository;

    protected $productRepository;

    protected $imageService;

    protected $excel;

    public function __construct(
        EntityManagerInterface $entityManager,
        PromotionRepository $promotionRepository,
        ProductRepository $productRepository,
        ImageService $imageService,
        Excel $excel
    ) {
        $this->entityManager = $entityManager;
        $this->promotionRepository = $promotionRepository;
        $this->productRepository = $productRepository;
        $this->imageService = $imageService;
        $this->excel = $excel;
    }

    public function addProducts($promotion, array $products)
    {
        $promotion = $this->normalizePromotion($promotion);


        foreach ($products as $product) {

            $product = $this->normalizeProduct($product);

            if ($this->canBeAdded($product, $promotion)) {

                $item = new PromotionItem;

                $item->setPromotion($promotion)
                    ->setProduct($product);

                $promotion->addItem($item);

            }

        }

        $this->promotionRepository->save($promotion);
    }

    public function addProductsFromFilters($promotionId, array $filters)
    {
        $countries = array_get($filters, 'countries', []);
        $regions = array_get($filters, 'regions', []);
        $producers = array_get($filters, 'producers', []);
        $types = array_get($filters, 'types', []);

        $promotion = $this->promotionRepository->getOneById($promotionId);

        if (! empty($countries)) {
            $this->addProductsFromCountries($promotion, $countries);
        }

        if (! empty($regions)) {
            $this->addProductsFromRegions($promotion, $regions);
        }

        if (! empty($producers)) {
            $this->addProductsFromProducers($promotion, $producers);
        }

        if (! empty($types)) {
            $this->addProductsFromTypes($promotion, $types);
        }
    }

    public function addProductsFromCountries($promotionId, array $countries)
    {
        $products = $this->productRepository->getProductsFromCountries($countries);

        $this->addProducts($promotionId, $products);
    }

    public function addProductsFromRegions($promotionId, array $regions)
    {
        $products = $this->productRepository->getProductsFromRegions($regions);

        $this->addProducts($promotionId, $products);
    }

    public function addProductsFromProducers($promotionId, array $producers)
    {
        $products = $this->productRepository->getProductsFromProducers($producers);

        $this->addProducts($promotionId, $products);
    }

    public function addProductsFromTypes($promotionId, array $types)
    {
        $products = $this->productRepository->getProductsFromTypes($types);

        $this->addProducts($promotionId, $products);
    }

    public function addAllProducts($promotion)
    {
        $promotion = $this->normalizePromotion($promotion);

        $qb = $this->productRepository->createQueryBuilder('p');

        $qb->where($qb->expr()->notIn('p.productType', $this->getNotAllowedProductTypes()));

        $iterableResult = $qb->getQuery()->iterate();

        $stmt = $this->entityManager->getConnection()->prepare('
        INSERT INTO promotions_items (promotion_id, product_id, created_at, updated_at) VALUES (?,?,?,?);');

        foreach ($iterableResult as $row) {
            $product = $row[0];

            if ($this->canBeAdded($product, $promotion)) {
                $stmt->execute([$promotion->getId(), $product->getId(), Carbon::now(), Carbon::now()]);
            }

        }
    }

    public function attachProductsFromExcel($promotion, UploadedFile $excelFile)
    {
        $result = [];

        $this->excel->load($excelFile->getRealPath(), function(LaravelExcelReader $reader) use (&$result, $promotion) {
            $reader->sheet(0, function($sheet) use (&$result, $promotion) {
                $productsIds = $this->filterProductsIdsFromSheet($sheet);

                $this->addProducts($promotion, $productsIds);

            });
        });
    }

    protected function filterProductsIdsFromSheet($sheet)
    {
        $data = collect(array_column($sheet->toArray(), 0));
        return $data->filter(function($product) {
            return ! empty($product) && intval($product) > 0;
        })->map(function($product) {
            return intval($product);
        })->toArray();
    }

    public function removeItem($promotionId, $item)
    {
        $promotion = $this->promotionRepository->getOneById($promotionId);

        $item = $this->entityManager->getReference(PromotionItem::class, $item);

        $promotion->removeItem($item);

        $this->promotionRepository->save($promotion);
    }

    protected function normalizeProduct($product)
    {
        return is_object($product) ?
            $product : $this->entityManager->getReference(Product::class, $product);
    }

    private function normalizePromotion($promotion)
    {
        return is_object($promotion) ?
            $promotion : $this->promotionRepository->getOneById($promotion);
    }

    protected function getNotAllowedProductTypes()
    {
        return [
            ProductType::TYPE_ACCESSORY,
            ProductType::TYPE_ALIMENTARY,
            ProductType::TYPE_PACKING
        ];
    }

    protected function canBeAdded(ProductInterface $product, PromotionInterface $promotion)
    {
        return ! in_array($product->getProductType()->getId(), $this->getNotAllowedProductTypes());
    }

    protected function saveSealImage(PromotionInterface $promotion, $image)
    {
        if (! empty($image)) {
            $seal = $this->imageService->storeFor($promotion, $image);

            $promotion->setSealImage($seal);
        }

        $this->promotionRepository->save($promotion);
    }

}
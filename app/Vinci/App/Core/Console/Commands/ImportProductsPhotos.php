<?php

namespace Vinci\App\Core\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Http\UploadedFile;
use Log;
use Storage;
use Vinci\Domain\File\Mapping\DefaultFileMapping;
use Vinci\Domain\Image\Image;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Image\ImageVersion;
use Vinci\Domain\Product\Image\ProductImagePathBuilder;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Services\ProductImageService;
use Intervention\Image\Facades\Image as InterventionImage;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;
use Vinci\Infrastructure\Storage\StorageService;

class ImportProductsPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:import-photos { --directory=? }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products photos from a given directory';

    private $productImageService;

    private $productRepository;
    
    private $storageService;

    private $imageRepository;

    public function __construct(
        ProductImageService $productImageService,
        ProductRepository $productRepository,
        StorageService $storageService,
        ImageRepository $imageRepository
    ) {
        parent::__construct();

        $this->productImageService = $productImageService;
        $this->productRepository = $productRepository;
        $this->storageService = $storageService;
        $this->imageRepository = $imageRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = collect(Storage::disk('local')->files('products_images'));
        $success = [];
        $error = [];

        $this->info(sprintf('Importing %s photos...', $files->count()));

        $progressBar = $this->output->createProgressBar($files->count());

        foreach ($files as $file) {

            $path = storage_path(sprintf('app/%s', $file));
            $sku = $this->parseProductSku($path);

            try {

                $this->importOne($path, $sku);

                $success[] = $sku;

            } catch (Exception $e) {
                $error[] = $sku;

                Log::error(sprintf('Error when importing image of product #%s: %s', $sku, $e->getMessage()));
            }

            $progressBar->advance();

        }

        $progressBar->finish();

        $this->info("Done!\n");

        if (count($success) > 0) {
            $this->info(sprintf('%s photos imported with success!', count($success)));
        }

        if (count($error) > 0) {
            $this->error(sprintf('%s photos were not imported!', count($error)));
        }
    }

    protected function importOne($path, $sku)
    {
        $product = $this->productRepository->findOneBySKU($sku);

        if (! $product) {
            throw new EntityNotFoundException('Product does not exists.');
        }

        $filePath = $path;

        $file = new UploadedFile($filePath, sprintf('%s.png', $sku));

        $photo = Image::makeFromUpload($file);

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
        $this->productRepository->save($product);

        Storage::delete([
            storage_path('app/tmp/small.png'),
            storage_path('app/tmp/medium.png'),
        ]);

        app('em')->clear();
    }

    private function parseProductSku($path)
    {
        $segments = explode('/', $path);
        return explode('.', last($segments))[0];
    }

}
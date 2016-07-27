<?php

namespace Vinci\App\Core\Console\Commands;

use DB;
use Exception;
use Illuminate\Console\Command;
use Vinci\Domain\Core\BaseTaxonomy;
use Vinci\Domain\ProductType\ProductType;
use Vinci\Domain\ProductType\ProductTypeService;

class ImportProductsTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:products-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import products types';

    private $productTypeService;

    public function __construct(ProductTypeService $productTypeService)
    {
        parent::__construct();

        $this->productTypeService = $productTypeService;
    }

    public function handle()
    {
        $db = DB::connection('homolog');

        $productsTypes = collect($db->table('w11_productType')->get());

        if ($total = $productsTypes->count()) {

            $this->info(sprintf('Importing %s products types...', $total));
            $bar = $this->output->createProgressBar($total);
            $success = 0;
            $errors = 0;

            foreach ($productsTypes as $productType) {

                $metadata = app('em')->getClassMetaData(BaseTaxonomy::class);
                $metadata2 = app('em')->getClassMetaData(ProductType::class);

                $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
                $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                $metadata2->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
                $metadata2->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

                try {

                    $this->productTypeService->create([
                        'id' => $productType->id,
                        'name' => $productType->title,
                        'description' => $productType->description,
                        'slug' => $productType->slug,
                        'visible_site' => $productType->visibleSite,
                        'status' => 1,
                        'seoTitle' => $productType->seo_title,
                        'seoDescription' => $productType->seo_description,
                    ]);

                    $success++;

                } catch (Exception $e) {
                    $errors++;
                }

                $bar->advance();

            }

            $bar->finish();

            $this->info('Done!');

            if ($success > 0) {
                $this->info(sprintf('%s products types imported with success!', $success));
            }

            if ($errors > 0) {
                $this->error(sprintf('%s products types were not imported!', $errors));
            }

        } else {
            $this->info('Nothing to do.');
        }

    }

}
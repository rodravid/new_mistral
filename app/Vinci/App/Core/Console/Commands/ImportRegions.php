<?php

namespace Vinci\App\Core\Console\Commands;

use DB;
use Exception;
use Illuminate\Console\Command;
use Vinci\Domain\Core\BaseTaxonomy;
use Vinci\Domain\Region\Region;
use Vinci\Domain\Region\RegionService;

class ImportRegions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:regions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import regions';

    private $regionService;

    public function __construct(RegionService $regionService)
    {
        parent::__construct();

        $this->regionService = $regionService;
    }

    public function handle()
    {
        $db = DB::connection('homolog');

        $regions = collect($db->table('w11_regions as r')->distinct()->join('w11_regions_countries_relationship as rc', 'r.id', '=', 'rc.region_id')->get());

        if ($total = $regions->count()) {

            $this->info(sprintf('Importing %s regions...', $total));
            $bar = $this->output->createProgressBar($total);
            $success = 0;
            $errors = 0;

            $metadata = app('em')->getClassMetaData(BaseTaxonomy::class);
            $metadata2 = app('em')->getClassMetaData(Region::class);

            $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $metadata2->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $metadata2->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());

            foreach ($regions as $region) {

                try {

                    $this->regionService->create([
                        'id' => $region->region_id,
                        'country' => $region->country_id,
                        'name' => $region->title,
                        'description' => $region->description,
                        'slug' => $region->slug,
                        'visible_site' => $region->visibleSite,
                        'status' => 1,
                        'seoTitle' => $region->seo_title,
                        'seoDescription' => $region->seo_description,
                    ]);

                    $success++;

                } catch (Exception $e) {

                    throw $e;

                    $errors++;
                }

                $bar->advance();

            }

            $bar->finish();

            $this->info('Done!');

            if ($success > 0) {
                $this->info(sprintf('%s regions imported with success!', $success));
            }

            if ($errors > 0) {
                $this->error(sprintf('%s regions were not imported!', $errors));
            }

        } else {
            $this->info('Nothing to do.');
        }

    }

}
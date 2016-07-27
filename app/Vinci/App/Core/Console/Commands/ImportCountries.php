<?php

namespace Vinci\App\Core\Console\Commands;

use DB;
use Exception;
use Illuminate\Console\Command;
use Vinci\Domain\Core\BaseTaxonomy;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Country\CountryService;

class ImportCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import countries';

    private $countryService;

    public function __construct(CountryService $countryService)
    {
        parent::__construct();

        $this->countryService = $countryService;
    }
    
    public function handle()
    {
        $db = DB::connection('homolog');

        $countries = collect($db->table('w11_countries')->get());

        if ($total = $countries->count()) {

            $this->info(sprintf('Importing %s countries...', $total));
            $bar = $this->output->createProgressBar($total);
            $success = 0;
            $errors = 0;

            foreach ($countries as $country) {

                $metadata = app('em')->getClassMetaData(BaseTaxonomy::class);
                $metadata2 = app('em')->getClassMetaData(Country::class);

                $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
                $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
                $metadata2->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
                $metadata2->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

                try {

                    $this->countryService->create([
                        'id' => $country->id,
                        'name' => $country->title,
                        'description' => $country->description,
                        'slug' => $country->slug,
                        'visible_site' => $country->visibleSite,
                        'status' => 1,
                        'seoTitle' => $country->seo_title,
                        'seoDescription' => $country->seo_description,
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
                $this->info(sprintf('%s countries imported with success!', $success));
            }

            if ($errors > 0) {
                $this->error(sprintf('%s countries were not imported!', $errors));
            }

        } else {
            $this->info('Nothing to do.');
        }

    }

}
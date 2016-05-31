<?php

namespace Vinci\App\Core\Console\Commands;

use Carbon\Carbon;
use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Country\Country;
use Vinci\Domain\Country\CountryService;
use Vinci\Domain\Customer\CustomerService;
use Vinci\Domain\Product\Services\ProductManagementService;
use GuzzleHttp\Client;

class MakeSlugCountry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:make:slug:countries:slugs {limit=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera os slugs para os países que ainda não possuem os slugs';

    private $em;

    public function __construct(EntityManager $em)
    {
        parent::__construct();

        $this->em = $em;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->create();
    }

   
    public function create()
    {
        $conn = $this->em->getConnection();

        $stmt = $conn->prepare('select * from countries where slug is NULL limit ' . $this->argument('limit') );
        $stmt->execute();

        $countries = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $total = count($countries);

        $error = 0;

        if ($total) {
            $this->line('');
            $this->info("importing " . $total . " countries(s).");
            $this->line('');

            $progressBar = $this->output->createProgressBar($total);
            foreach ($countries as $country) {

                $obj = $this->em->getRepository(Country::class)->find($country['id']);
                $obj->setSlug($country['name']);
                $this->em->persist($obj);
                $this->em->flush();

                $progressBar->advance();

            }
            $progressBar->finish();
            $this->line("\n");
            $this->info($error . ' error');
            $this->info(($total - $error) . ' imported');
            $this->line('');

        }
    }

}
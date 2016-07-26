<?php

namespace Vinci\App\Core\Console\Commands;

use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;
use PDO;

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

        $conn = $this->em->getConnection();

        $stmt = $conn->prepare('SELECT * FROM w11_countries');

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $country) {
            dd($country);
        }

    }

}
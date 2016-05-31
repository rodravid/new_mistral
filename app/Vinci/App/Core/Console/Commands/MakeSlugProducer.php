<?php

namespace Vinci\App\Core\Console\Commands;

use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;
use Vinci\Domain\Producer\Producer;

class MakeSlugProducer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:make:slug:producer:slugs {limit=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera os slugs para os produtores que ainda não possuem os slugs';

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

        $stmt = $conn->prepare('select * from producers where slug is NULL limit ' . $this->argument('limit') );
        $stmt->execute();

        $items = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $total = count($items);

        $error = 0;

        if ($total) {
            $this->line('');
            $this->info("importing " . $total . " producer(s).");
            $this->line('');

            $progressBar = $this->output->createProgressBar($total);
            foreach ($items as $item) {

                $obj = $this->em->getRepository(Producer::class)->find($item['id']);
                $obj->setSlug($item['name']);
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
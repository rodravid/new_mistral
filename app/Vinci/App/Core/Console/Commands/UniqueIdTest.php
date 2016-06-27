<?php

namespace Vinci\App\Core\Console\Commands;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Ramsey\Uuid\Uuid;

class UniqueIdTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:unique-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test unique ids';

    private $em;

    public function __construct(EntityManagerInterface $em)
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
        ini_set('memory_limit','512M');

        $this->info('Generating ids...');

        $max = 1000000;
        $progressBar = $this->output->createProgressBar($max);

        $stmt = $this->em->getConnection()->prepare('INSERT INTO table_ids (id, short_id, end_short, sha1_id, sha1_short) VALUES (?,?,?,?,?);');

        for ($i = 0; $i <= $max; $i++) {

            $id = Uuid::uuid4();
            $segments = explode('-', $id);
            $short = $segments[0];
            $last = end($segments);

            $sha1 = sha1($id);
            $sha1Short = substr($sha1, 0, 11);

            $stmt->execute([$id, $short, $last, $sha1, $sha1Short]);

            $progressBar->advance();
        }

        $progressBar->finish();
    }

}
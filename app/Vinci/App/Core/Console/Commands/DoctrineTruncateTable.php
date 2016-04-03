<?php

namespace Vinci\App\Core\Console\Commands;

use Doctrine\ORM\EntityManager;
use Illuminate\Console\Command;

class DoctrineTruncateTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doctrine:schema:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate tables';

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

        $platform = $conn->getDatabasePlatform();

        $schemaManager = $conn->getSchemaManager();

        $tables = $schemaManager->listTables();

        $conn->executeQuery('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {

            $tableName = $table->getName();
            $truncateSql = $platform->getTruncateTableSQL($tableName);
            $conn->executeUpdate($truncateSql);

            $this->info("Table {$tableName} truncated!");

        }

        $conn->executeQuery('SET FOREIGN_KEY_CHECKS = 1;');

        $this->info('Done!');

    }

}
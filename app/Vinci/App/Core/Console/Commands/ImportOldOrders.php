<?php

namespace Vinci\App\Core\Console\Commands;

use DB;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Order\Order;

class ImportOldOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:old-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import old orders of customers';

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

        $channel = $this->em->getReference(Channel::class, 1);

        //$progressBar = $this->output->createProgressBar();

        $oldOrders = DB::table('tbOrder')->get();

        foreach ($oldOrders as $oldOrder) {

            $order = new Order;

            $order->setChannel($channel);

        }


    }

}
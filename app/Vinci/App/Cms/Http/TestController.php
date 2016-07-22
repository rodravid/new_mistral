<?php

namespace Vinci\App\Cms\Http;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Queue\Factory as QueueManager;
use Vinci\Domain\Order\Order;

class TestController extends Controller
{
    private $queue;

    public function __construct(EntityManagerInterface $em, QueueManager $queue)
    {
        parent::__construct($em);

        $this->queue = $queue;
    }

    public function index()
    {

        $order = new Order();

        dd($order);


//        for ($i = 0; $i <= 50; $i++) {
//            $this->queue->connection('database')
//                ->pushOn('fila1', new TestJob());
//        }
//
//        for ($i = 0; $i <= 50; $i++) {
//            $this->queue->connection('database')
//                ->pushOn('fila2', new TestJob2());
//        }

        return 'Done!';
    }
}
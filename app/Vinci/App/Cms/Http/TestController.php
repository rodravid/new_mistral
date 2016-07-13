<?php

namespace Vinci\App\Cms\Http;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Queue\Factory as QueueManager;

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

        $job = $this->queue->connection('sqs')->pushOn('vinci-teste', new TestJob());

        dd($job);

    }

}
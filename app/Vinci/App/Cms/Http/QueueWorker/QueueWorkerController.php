<?php

namespace Vinci\App\Cms\Http\QueueWorker;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Response;
use Vinci\App\Cms\Http\Controller;

class QueueWorkerController extends Controller
{

    private $queueWorkerService;

    public function __construct(EntityManagerInterface $em, QueueWorkerService $queueWorkerService)
    {
        parent::__construct($em);

        $this->queueWorkerService = $queueWorkerService;
    }

    public function index()
    {
        try {

            return Response::json($this->queueWorkerService->getQueueWorkersStatusCron());

        } catch (Exception $e) {

            return Response::json([
                'message' => $e->getMessage()
            ], 500);

        }
    }

    public function getQueueWorkerStatus()
    {
        try {

            return Response::json($this->queueWorkerService->getQueueWorkersStatus());

        } catch (Exception $e) {

            return Response::json([
                'message' => $e->getMessage()
            ]);

        }
    }

}
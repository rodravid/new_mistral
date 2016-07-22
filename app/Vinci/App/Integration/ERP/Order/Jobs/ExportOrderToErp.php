<?php

namespace Vinci\App\Integration\ERP\Order\Jobs;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vinci\App\Core\Jobs\Job;
use Vinci\App\Integration\ERP\Order\OrderExporter;
use Vinci\App\Integration\Exceptions\CustomerNotIntegratedException;
use Vinci\Domain\Order\OrderRepository;

class ExportOrderToErp extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle(OrderRepository $repository, OrderExporter $exporter, EntityManagerInterface $entityManager)
    {
        try {

            $order = $repository->getOneById($this->orderId);

            $exporter->export($order);

            $entityManager->clear();

        } catch (CustomerNotIntegratedException $e) {

            $this->attempts() < 3 ?
                $this->release() : $this->delete();

            throw $e;

        } catch (Exception $e) {

            $this->delete();

            throw $e;
        }
    }

}
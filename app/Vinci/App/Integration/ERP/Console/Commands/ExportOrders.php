<?php

namespace Vinci\App\Integration\ERP\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Queue;
use Vinci\App\Integration\ERP\Order\Jobs\ExportOrderToErp;
use Vinci\App\Integration\ERP\Order\OrderExporter;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\Order\OrderRepository;

class ExportOrders extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:orders:export 
                            {orders?* : IDs array of orders}
                            {--with-failed : Include orders failed}
                            {--queued : Put orders on integration queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export orders to ERP.';

    private $orderExporter;

    private $orderRepository;

    public function __construct(OrderExporter $orderExporter, OrderRepository $orderRepository)
    {
        parent::__construct();

        $this->orderExporter = $orderExporter;
        $this->orderRepository = $orderRepository;
    }

    public function handle()
    {
        list($count, $ordersIterator) = $this->getOrders();

        if ($count > 0) {

            if ($this->option('queued')) {
                $this->info(sprintf("Putting #%s order(s) in integration queue...\n", $count));
            } else {
                $this->info(sprintf("Exporting #%s order(s) to ERP...\n", $count));
            }

            $progressBar = $this->output->createProgressBar($count);

            $success = [];
            $error = [];

            foreach ($ordersIterator as $row) {

                $order = $row[0];

                try {

                    $this->exportOne($order, true, true);

                    $success[] = $order->getId();

                } catch (Exception $e) {
                    $error[] = $order->getId();
                }

                $progressBar->advance();
            }

            $progressBar->finish();

            $this->info("\n\nDone!");

            if (! empty($success)) {

                if ($this->option('queued')) {
                    $this->info(sprintf("\n%s order(s) were placed in integration queue!", count($success)));
                } else {
                    $this->info(sprintf("\n%s order(s) exported with success!", count($success)));
                }

            }

            if (! empty($error)) {

                if ($this->option('queued')) {
                    $this->error(sprintf("\n%s order(s) were not placed on integration queue!", count($error)));
                } else {
                    $this->error(sprintf("\n%s order(s) were not exported!", count($error)));
                }

            }

        } else {
            $this->info('Nothing to do.');
        }
    }

    public function exportOne(OrderInterface $order, $silent = false, $exceptions = false)
    {
        if (! $silent) {
            $this->info(sprintf('Exporting order #%s to ERP...', $order->getId()));
        }

        try {

            if ($this->option('queued')) {
                Queue::pushOn('vinci-integration-orders', new ExportOrderToErp($order->getId()));

            } else {
                $this->orderExporter->export($order);
            }

            if (! $silent) {
                $this->info('Done!');
            }

        } catch (Exception $e) {

            if ($exceptions) {
                throw $e;
            }

            if (! $silent) {
                $this->error($e->getMessage());
            }

        }
    }

    public function getOrders()
    {
        $ordersInput = $this->getOrdersInput();

        $qb = $this->orderRepository->createQueryBuilder('o');

        if ($ordersInput->count()) {
            $qb->where($qb->expr()->in('o.id', $ordersInput->toArray()));
        } else {
            $qb->where($qb->expr()->in('o.erpIntegrationStatus', $this->getStatuses()));
        }

        $count = (int) $qb->select($qb->expr()->count('o.id'))->getQuery()->getSingleScalarResult();

        return [$count, $qb->select('o')->getQuery()->iterate()];
    }

    public function getOrdersInput()
    {
        return collect($this->argument('orders'));
    }

    private function getStatuses()
    {
        $status = [IntegrationStatus::PENDING];

        if ($this->option('with-failed')) {
            $status[] = IntegrationStatus::FAILED;
        }

        return $status;
    }
}
<?php

namespace Vinci\App\Integration\ERP\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Vinci\App\Integration\ERP\Order\OrderExporter;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\Order\Item\OrderItem;
use Vinci\Domain\Order\OrderRepository;

class ExportOrdersItems extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:orders:items:export 
                            {orders?* : IDs array of orders items}
                            {--with-failed : Include orders items failed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export orders to ERP.';

    private $orderExporter;

    private $orderRepository;

    public function __construct(OrderExporter $orderItemExporter, OrderRepository $orderItemRepository)
    {
        parent::__construct();

        $this->orderExporter = $orderItemExporter;
        $this->orderRepository = $orderItemRepository;
    }

    public function handle()
    {
        list($count, $orderItemIterator) = $this->getOrdersItems();

        if ($count > 0) {

            $this->info(sprintf("Exporting #%s order(s) to ERP...\n", $count));

            $progressBar = $this->output->createProgressBar($count);

            $success = [];
            $error = [];

            foreach ($orderItemIterator as $row) {

                $orderItem = $row[0];

                try {

                    $this->exportOne($orderItem, true, true);

                    $success[] = $orderItem->getId();

                } catch (Exception $e) {
                    $error[] = $orderItem->getId();
                }

                $progressBar->advance();
            }

            $progressBar->finish();

            $this->info("\n\nDone!");

            if (! empty($success)) {
                $this->info(sprintf("\n%s order(s) exported with success!", count($success)));
            }

            if (! empty($error)) {
                $this->error(sprintf("\n%s order(s) were not exported!", count($error)));
            }

        } else {
            $this->info('Nothing to do.');
        }
    }

    public function exportOne(OrderItem $orderItem, $silent = false, $exceptions = false)
    {
        if (! $silent) {
            $this->info(sprintf('Exporting order #%s to ERP...', $orderItem->getId()));
        }

        try {

            $this->orderExporter->exportItem($orderItem);

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

    public function getOrdersItems()
    {
        $orderItemsInput = $this->getOrdersInput();

        $qb = $this->orderRepository->getItemsQuery('i');

        if ($orderItemsInput->count()) {
            $qb->where($qb->expr()->in('i.id', $orderItemsInput->toArray()));
        } else {
            $qb->where($qb->expr()->in('i.erpIntegrationStatus', $this->getStatuses()));
        }

        $count = (int) $qb->select($qb->expr()->count('i.id'))->getQuery()->getSingleScalarResult();

        return [$count, $qb->select('i')->getQuery()->iterate()];
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
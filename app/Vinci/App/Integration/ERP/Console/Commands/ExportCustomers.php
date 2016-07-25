<?php

namespace Vinci\App\Integration\ERP\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Vinci\App\Integration\ERP\Customer\CustomerExporter;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\Customer\CustomerInterface;
use Vinci\Domain\Customer\CustomerRepository;

class ExportCustomers extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:integration:customers:export 
                            {customers?* : IDs array of customers}
                            {--with-failed : Include customers failed}
                            {--only-failed : Only failed customers failed}
                            {--only-pending : Only pending customers failed}
                            {--queued : Put cutomers on integration queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export customers to ERP.';

    private $customerExporter;

    private $customerRepository;

    public function __construct(CustomerExporter $customerExporter, CustomerRepository $customerRepository)
    {
        parent::__construct();

        $this->customerExporter = $customerExporter;
        $this->customerRepository = $customerRepository;
    }

    public function handle()
    {
        list($count, $customersIterator) = $this->getCustomers();

        if ($count > 0) {

            if ($this->option('queued')) {
                $this->info(sprintf("Putting #%s customer(s) in integration queue...\n", $count));
            } else {
                $this->info(sprintf("Exporting #%s customer(s) to ERP...\n", $count));
            }

            $progressBar = $this->output->createProgressBar($count);

            $success = [];
            $error = [];

            foreach ($customersIterator as $row) {

                $customer = $row[0];

                try {

                    $this->exportOne($customer, true, true);

                    $success[] = $customer->getId();

                } catch (Exception $e) {
                    $error[] = $customer->getId();
                }

                $progressBar->advance();
            }

            $progressBar->finish();

            $this->info("\n\nDone!");

            if (! empty($success)) {

                if ($this->option('queued')) {
                    $this->info(sprintf("\n%s customers(s) were placed in integration queue!", count($success)));
                } else {
                    $this->info(sprintf("\n%s customer(s) exported with success!", count($success)));
                }
            }

            if (! empty($error)) {

                if ($this->option('queued')) {
                    $this->error(sprintf("\n%s customers(s) were not placed on integration queue!", count($error)));
                } else {
                    $this->error(sprintf("\n%s customer(s) were not exported!", count($error)));
                }
            }

        } else {
            $this->info('Nothing to do.');
        }
    }

    public function exportOne(CustomerInterface $customer, $silent = false, $exceptions = false)
    {
        if (! $silent) {
            $this->info(sprintf('Exporting customer #%s to ERP...', $customer->getId()));
        }

        try {

            if ($this->option('queued')) {
                $this->customerExporter->exportQueued($customer);
            } else {
                $this->customerExporter->export($customer);
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

    public function getCustomers()
    {
        $customersInput = $this->getCustomersInput();

        $qb = $this->customerRepository->createQueryBuilder('c');

        if ($customersInput->count()) {
            $qb->where($qb->expr()->in('c.id', $customersInput->toArray()));
        } else {
            $qb->where($qb->expr()->in('c.erpIntegrationStatus', $this->getStatuses()));
        }

        $count = (int) $qb->select($qb->expr()->count('c.id'))->getQuery()->getSingleScalarResult();

        return [$count, $qb->select('c')->getQuery()->iterate()];
    }

    public function getCustomersInput()
    {
        return collect($this->argument('customers'));
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
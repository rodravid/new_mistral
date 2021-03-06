<?php

namespace Vinci\App\Integration\ERP\Customer\Jobs;

use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Vinci\App\Core\Jobs\Job;
use Vinci\App\Integration\ERP\Customer\CustomerExporter;
use Vinci\Domain\Customer\CustomerRepository;

class ExportCustomerToErp extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $customerId;

    public function __construct($customerId)
    {
        $this->customerId = $customerId;
    }

    public function handle(CustomerRepository $repository, CustomerExporter $exporter)
    {
        try {

            $customer = $repository->findOrFail($this->customerId);

            $exporter->export($customer);

        } catch (Exception $e) {

            $this->attempts() < 3 ?
                $this->release() : $this->delete();

            throw $e;

        } finally {
            app('em')->clear();
        }
    }

}
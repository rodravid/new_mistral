<?php

namespace Vinci\App\Core\Console\Commands;

use Carbon\Carbon;
use DB;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Console\Command;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Order\Address\Address;
use Vinci\Domain\Order\Order;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatus;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;

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

    private $channel;

    private $trackingStatus;

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
        $oldOrders = collect(DB::table('tbOrder as o')->join('tbOrderShippingAddress as oa', 'o.idOrder', '=', 'oa.idOrder')->get());

        if ($count = $oldOrders->count()) {

            $this->info(sprintf('Importing %s orders...', $count));

            $progressBar = $this->output->createProgressBar($count);
            $success = 0;
            $error = 0;

            foreach ($oldOrders as $oldOrder) {

                try {

                    $this->importOne($oldOrder);

                    $success++;

                } catch (Exception $e) {

                    dd($e->getMessage());
                    $error++;

                } finally {
                    $this->em->clear();
                }

                $progressBar->advance();
            }

            $progressBar->finish();

            $this->info("Done!\n");

            if ($success > 0) {
                $this->info(sprintf("%s orders imported with success!\n", $success));
            }

            if ($error > 0) {
                $this->error(sprintf('%s orders were not imported!', $error));
            }

        }

    }

    protected function importOne($oldOrder)
    {
        $customer = $this->getCustomer($oldOrder->idCustomer);

        $total = $this->parseDecimal($oldOrder->vlTotalOrder);
        $itemsTotal = $this->parseDecimal($oldOrder->vlTotalProduct);
        $shippingValue = $this->parseDecimal($oldOrder->vlTotalShipCost);
        $installments = (int) $oldOrder->nuParcelsNumber;
        $orderDate = Carbon::parse(trim($oldOrder->dtOrder));
        $number = trim($oldOrder->dsDispId);

        $order = new Order;

        $order->setChannel($this->getChannel())
            ->setTrackingStatus($this->getTrackingStatus())
            ->setNumber($number)
            ->setTotal($total)
            ->setItemsTotal($itemsTotal)
            ->setCustomer($customer)
            ->setCreatedAt($orderDate)
            ->setErpIntegrationStatus(IntegrationStatus::INTEGRATED);

        list($shippingAddress, $billingAddress) = $this->getAddresses($oldOrder, $order);

        dd($shippingAddress, $billingAddress);

        //@TODO Add order items
        //@TODO Add order billing address
        //@TODO Add order shipping address
        //@TODO Add order payment
        //@TODO Add order shipment
    }

    protected function parseDecimal($value)
    {
        return doubleval(substr_replace($value, ".", strlen($value) - 2) . substr($value, strlen($value) - 2));
    }

    private function getCustomer($customerId)
    {
        if (empty((int) $customerId)) {
            throw new Exception('The given customer id is empty.');
        }

        $customer = $this->em->getRepository(Customer::class)->findOneBy(['importId' => trim($customerId)]);

        if (! $customer) {
            throw new EntityNotFoundException(sprintf('The customer of id %s was not found.', $customerId));
        }

        return $customer;
    }

    protected function getAddresses($oldOrder, OrderInterface $newOrder)
    {
        $shippingAddress = new Address;

        $shippingAddress
            ->setAddress(trim($oldOrder->dsAddress))
            ->setNumber(trim($oldOrder->dsNumber))
            ->setDistrict(trim($oldOrder->dsDictrict))
            ->setComplement(trim($oldOrder->dsComplement))
            ->setLandmark(trim($oldOrder->dsReferenceAddress))
        ;

        dd($shippingAddress);

        $billingAddress = new Address;

        if (! empty($billAddress = $newOrder->getCustomer()->getMainAddress())) {
            $billingAddress->override($billAddress);
        } else {
            $billingAddress = clone $shippingAddress;
        }

        return [$shippingAddress, $billingAddress];
    }

    public function getChannel()
    {
        if (! is_null($this->channel)) {
            return $this->channel;
        }

        return $this->channel = $this->em->getReference(Channel::class, 1);
    }

    public function getTrackingStatus()
    {
        if (! is_null($this->trackingStatus)) {
            return $this->trackingStatus;
        }

        return $this->trackingStatus = $this->em->getReference(OrderTrackingStatus::class, 1);
    }

}
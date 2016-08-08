<?php

namespace Vinci\App\Core\Console\Commands;

use Carbon\Carbon;
use DB;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Console\Command;
use Vinci\Domain\Address\AddressType;
use Vinci\Domain\Address\City\City;
use Vinci\Domain\Address\PublicPlace;
use Vinci\Domain\Carrier\Carrier;
use Vinci\Domain\Channel\Channel;
use Vinci\Domain\Common\IntegrationStatus;
use Vinci\Domain\Customer\Customer;
use Vinci\Domain\Order\Address\Address;
use Vinci\Domain\Order\Item\OrderItem;
use Vinci\Domain\Order\Order;
use Vinci\Domain\Order\OrderInterface;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatus;
use Vinci\Domain\Payment\Payment;
use Vinci\Domain\Payment\PaymentMethod;
use Vinci\Domain\Product\ProductVariant;
use Vinci\Domain\Shipping\Shipment;
use Vinci\Infrastructure\Exceptions\EntityNotFoundException;
use Vinci\Infrastructure\Services\Postmon\Facades\Postmon;

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

                dd('ok');

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
        $order = new Order;

        $customer = $this->getCustomer($oldOrder->idCustomer);
        $total = $this->parseDecimal($oldOrder->vlTotalOrder);
        $itemsTotal = $this->parseDecimal($oldOrder->vlTotalProduct);
        $shippingValue = $this->parseDecimal($oldOrder->vlTotalShipCost);
        $deadline = trim($oldOrder->nuDeliveryTime);
        $installments = (int) $oldOrder->nuParcelsNumber;
        $orderDate = Carbon::parse(trim($oldOrder->dtOrder));
        $number = trim($oldOrder->dsDispId);

        $order
            ->setChannel($this->getChannel())
            ->setTrackingStatus($this->getTrackingStatus($oldOrder))
            ->setNumber($number)
            ->setTotal($total)
            ->setItemsTotal($itemsTotal)
            ->setCustomer($customer)
            ->setCreatedAt($orderDate)
            ->setErpIntegrationStatus(IntegrationStatus::INTEGRATED);

        list($shippingAddress, $billingAddress) = $this->getAddresses($oldOrder, $order);
        
        $order->setShippingAddress($shippingAddress);
        $order->setBillingAddress($billingAddress);

        $items = $this->getOrderItems($oldOrder);

        $order->setItems($items);

        $shipment = new Shipment;
        $shipment->setAmount($shippingValue)
            ->setDeadline($deadline)
            ->setCarrier($this->em->getReference(Carrier::class, 1));

        $order->setShipment($shipment);

        $payment = new Payment;

        $payment
            ->setAmount($order->getTotal())
            ->setInstallments($installments)
            ->setMethod($this->getPaymentMethod($oldOrder));

        $order->addPayment($payment);

        $this->em->persist($order);
        $this->em->flush($order);

        //@TODO Add order payment
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

        $postalCode = only_numbers($oldOrder->dsZip);

        $shippingAddress
            ->setAddress(trim($oldOrder->dsAddress))
            ->setNumber(trim($oldOrder->dsNumber))
            ->setDistrict(trim($oldOrder->dsDistrict))
            ->setComplement(trim($oldOrder->dsComplement))
            ->setLandmark(trim($oldOrder->dsReferenceAddress))
            ->setPublicPlace($this->em->getReference(PublicPlace::class, trim($oldOrder->idAddressType)))
            ->setType(new AddressType(1))
            ->setPostalCode($postalCode)
            ->setCreatedAt($newOrder->getCreatedAt());

        $addressData = Postmon::getAddress($postalCode);

        if (! empty($cityCode = array_get($addressData, 'cidade_info.codigo_ibge'))) {
            $shippingAddress->setCity($this->em->getReference(City::class, $cityCode));
        }

        $billingAddress = new Address;

        if (! empty($billAddress = $newOrder->getCustomer()->getMainAddress())) {
            $billingAddress->override($billAddress);
        } else {
            $billingAddress = clone $shippingAddress;
        }

        if (empty($shippingAddress->getCity()) && ! empty($billingAddress->getCity())) {
            $shippingAddress->setCity($billingAddress->getCity());
        }

        $shippingAddress->setErpIntegrationStatus(IntegrationStatus::INTEGRATED);
        $billingAddress->setErpIntegrationStatus(IntegrationStatus::INTEGRATED);

        return [$shippingAddress, $billingAddress];
    }

    protected function getChannel()
    {
        if (! is_null($this->channel)) {
            return $this->channel;
        }

        return $this->channel = $this->em->getReference(Channel::class, 1);
    }

    protected function getTrackingStatus($oldOrder)
    {
        $mapping = [
            103 => 1,
            105 => 3,
            107 => 7,
            108 => 5,
            121 => 9,
            998 => 2,
            999 => 8
        ];

        if (! empty($status = array_get($mapping, trim($oldOrder->idOrderStatus)))) {
            return $this->em->getReference(OrderTrackingStatus::class, $status);
        }

        return $this->em->getReference(OrderTrackingStatus::class, 1);
    }

    private function getOrderItems($oldOrder)
    {
        $oldItems = collect(DB::table('tbOrderIem')->where(['idOrder' => $oldOrder->idOrder])->get());

        if (! $oldItems->count()) {
            throw new Exception(sprintf('Order %s does not contains items.', $oldOrder->idOrder));
        }

        $items = new ArrayCollection;

        foreach ($oldItems as $oldItem) {

            $item = new OrderItem;

            $variant = $this->getProductVariant(trim($oldItem->idSku_FK));
            $price = $this->parseDecimal($oldItem->vlFinalSalePrice);
            $originalPrice = $this->parseDecimal($oldItem->vlOriginalSalePrice);
            $quantity = intval($oldItem->nuQuantity);
            $total = $price * $quantity;

            $item
                ->setProductVariant($variant)
                ->setPrice($price)
                ->setOriginalPrice($originalPrice)
                ->setAliquotIpi(0)
                ->setQuantity($oldItem->nuQuantity)
                ->setTotal($total)
                ->setErpIntegrationStatus(IntegrationStatus::INTEGRATED);

            $items->add($item);
        }

        return $items;
    }

    protected function getPaymentMethod($oldOrder)
    {
        if ($oldOrder->idPayMethod == 9) {
            return $this->em->getReference(PaymentMethod::class, 5);
        }

        $paymentInfo = DB::table('tbOrderPaymentDetailLog')->where('idOrder', $oldOrder->idOrder)->first();

        dd($paymentInfo);

    }

    private function getProductVariant($sku)
    {
        $variant = $this->em->getRepository(ProductVariant::class)->findOneBy(['sku' => $sku]);

        if (! $variant) {
            throw new EntityNotFoundException(sprintf('The product of id %s not found.', $sku));
        }
        
        return $variant;
    }

}
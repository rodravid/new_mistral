<?php
/**
 * Created by PhpStorm.
 * User: webeleven
 * Date: 17/06/16
 * Time: 14:06
 */

namespace Vinci\Domain\Dashboard;

use Carbon\Carbon;
use Vinci\Domain\Order\OrderRepository;
use Vinci\Domain\Customer\CustomerRepository;
use Vinci\Domain\Newsletter\NewsletterRepository;
use Vinci\Domain\Product\Repositories\ProductRepository;

class DashboardMetricsService
{
    private $orderRepository;
    private $productRepository;
    private $customerRepository;
    private $newsletterRepository;

    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        CustomerRepository $customerRepository,
        NewsletterRepository $newsletterRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->customerRepository = $customerRepository;
        $this->newsletterRepository = $newsletterRepository;
    }

    public function countOrders()
    {
        return $this->orderRepository->countOrders();
    }

    public function countOrdersByPeriod($startAt = null, $endAt = null)
    {

        $startAt = ((empty($startAt)) ? Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 00:00:00', strtotime('-10 days'))) : $startAt);
        $endAt = ((empty($endAt)) ? Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 23:59:59')) : $endAt);

        return $this->orderRepository->countOrdersByPeriod($startAt, $endAt);

    }

    public function countPaidOrdersByPeriod($startAt = null, $endAt = null)
    {

        $startAt = ((empty($startAt)) ? Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 00:00:00', strtotime('-10 days'))) : $startAt);
        $endAt = ((empty($endAt)) ? Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 23:59:59')) : $endAt);

        return $this->orderRepository->countPaidOrdersByPeriod($startAt, $endAt);

    }

    public function countWaitingPaymentOrdersByPeriod($startAt = null, $endAt = null)
    {
        $startAt = ((empty($startAt)) ? Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 00:00:00', strtotime('-10 days'))) : $startAt);
        $endAt = ((empty($endAt)) ? Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 23:59:59')) : $endAt);

        return $this->orderRepository->countWaitingPaymentOrdersByPeriod($startAt, $endAt);

    }

    public function countCompletedOrdersByPeriod($startAt = null, $endAt = null)
    {
        $startAt = ((empty($startAt)) ? Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 00:00:00', strtotime('-10 days'))) : $startAt);
        $endAt = ((empty($endAt)) ? Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 23:59:59')) : $endAt);

        return $this->orderRepository->countCompletedOrdersByPeriod($startAt, $endAt);
    }

    public function getLastOrders($perPage, $currentPage = 1)
    {
        return $this->orderRepository->getLastOrders($perPage, $currentPage);
    }

    public function countProducts()
    {
        return $this->productRepository->countProducts();
    }

    public function getLastProducts($perPage, $currentPage = 1)
    {
        return $this->productRepository->getLastProducts($perPage, $currentPage);
    }

    public function countCustomers()
    {
        return $this->customerRepository->countCustomers();
    }

    public function countNewsletters()
    {
        return $this->newsletterRepository->countNewsletters();
    }
}
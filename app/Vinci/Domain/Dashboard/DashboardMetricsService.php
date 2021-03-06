<?php

namespace Vinci\Domain\Dashboard;

use Vinci\Domain\Common\Model\DateRange;
use Vinci\Domain\Common\Period;
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

    public function countOrdersByPeriod($daysAgo = Period::DAYS_AGO_CHARTS)
    {

        return $this->orderRepository->countOrdersByPeriod(DateRange::getPeriod($daysAgo));

    }

    public function countPaidOrdersByPeriod($daysAgo = Period::DAYS_AGO_CHARTS)
    {

        return $this->orderRepository->countPaidOrdersByPeriod(DateRange::getPeriod($daysAgo));

    }

    public function countWaitingPaymentOrdersByPeriod($daysAgo = Period::DAYS_AGO_CHARTS)
    {

        return $this->orderRepository->countWaitingPaymentOrdersByPeriod(DateRange::getPeriod($daysAgo));

    }

    public function countCompletedOrdersByPeriod($daysAgo = Period::DAYS_AGO_CHARTS)
    {

        return $this->orderRepository->countCompletedOrdersByPeriod(DateRange::getPeriod($daysAgo));

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
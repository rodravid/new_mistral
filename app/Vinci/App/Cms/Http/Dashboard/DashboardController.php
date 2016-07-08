<?php

namespace Vinci\App\Cms\Http\Dashboard;

use Doctrine\ORM\EntityManagerInterface;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Cms\Http\Order\Presenters\OrderPresenter;
use Vinci\App\Cms\Http\Product\Presenters\ProductPresenter;
use Vinci\Domain\Dashboard\DashboardMetricsService;

class DashboardController extends Controller
{

    protected $dashboardMetricsService;

    public function __construct(EntityManagerInterface $em, DashboardMetricsService $dashboardMetricsService)
    {
        parent::__construct($em);

        $this->dashboardMetricsService = $dashboardMetricsService;
    }

    public function index()
    {
        if ($this->user->cannotManageModule('dashboard')) {
            return $this->view('dashboard.default');
        }

        $totalOrders = $this->dashboardMetricsService->countOrders();
        $totalOrdersOfLastDays = $this->dashboardMetricsService->countOrdersByPeriod();
        $totalPaidOrdersOfLastDays = $this->dashboardMetricsService->countPaidOrdersByPeriod();
        $totalCompletedOrdersOfLastDays = $this->dashboardMetricsService->countCompletedOrdersByPeriod();
        $totalWaitingPaymentOrdersOfLastDays = $this->dashboardMetricsService->countWaitingPaymentOrdersByPeriod();

        $lastOrders = $this->dashboardMetricsService->getLastOrders(10);
        $lastOrders = $this->presenter->paginator($lastOrders, OrderPresenter::class);

        $totalProducts = $this->dashboardMetricsService->countProducts();
        $lastProductsAdded = $this->dashboardMetricsService->getLastProducts(5);
        $lastProductsAdded = $this->presenter->paginator($lastProductsAdded, ProductPresenter::class);

        $totalCustomers = $this->dashboardMetricsService->countCustomers();
        $totalNewsletters = $this->dashboardMetricsService->countNewsletters();

        return $this->view('dashboard.index',
                                compact('lastOrders',
                                        'totalOrders',
                                        'totalProducts',
                                        'totalCustomers',
                                        'totalNewsletters',
                                        'lastProductsAdded',
                                        'totalOrdersOfLastDays',
                                        'totalPaidOrdersOfLastDays',
                                        'totalCompletedOrdersOfLastDays',
                                        'totalWaitingPaymentOrdersOfLastDays'
                                ));
    }

}
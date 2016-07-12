<?php

namespace Vinci\App\Cms\Http\Graphics;

use Carbon\Carbon;
use Response;
use Vinci\App\Cms\Http\Controller;
use Vinci\Domain\Common\Model\DateRange;
use Vinci\Domain\Graphic\Order\OrderGraphicsRepository;
use Vinci\Domain\Order\OrderRepository;

class GraphicsController extends Controller
{
    private $orderRepository;

    private $orderGraphicsRepository;

    public function __construct(OrderRepository $orderRepository, OrderGraphicsRepository $orderGraphicsRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderGraphicsRepository = $orderGraphicsRepository;
    }

    public function getDataForOrdersLineChart()
    {
        $data = $this->orderGraphicsRepository->countAllByPeriod(DateRange::getPeriod());

        return Response::json($data);
    }

    public function getDataForOrdersBarChart()
    {

        $orders = $this->orderGraphicsRepository->countPaidByPeriod(DateRange::getPeriod());

        return Response::json($orders);
    }
}
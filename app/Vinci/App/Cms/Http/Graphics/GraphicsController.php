<?php

namespace Vinci\App\Cms\Http\Graphics;

use Carbon\Carbon;
use Response;
use Vinci\App\Cms\Http\Controller;
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
        $startAt = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 00:00:00', strtotime('-10 days')));
        $stopAt = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 23:59:59'));

        $data = $this->orderGraphicsRepository->countAllByPeriod($startAt, $stopAt);

        return Response::json($data);
    }

    public function getDataForOrdersBarChart()
    {
        $dateStart = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 00:00:00', strtotime('-10 days')));
        $dateStop = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 23:59:59'));

        $orders = $this->orderGraphicsRepository->countPaidByPeriod($dateStart, $dateStop);

        return Response::json($orders);
    }
}
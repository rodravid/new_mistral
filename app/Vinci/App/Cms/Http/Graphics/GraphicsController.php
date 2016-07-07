<?php

namespace Vinci\App\Cms\Http\Graphics;

use Carbon\Carbon;
use Response;
use Vinci\App\Cms\Http\Controller;
use Vinci\Domain\Order\OrderRepository;

class GraphicsController extends Controller
{
    private $orderRepository;

    public function __construct(
        OrderRepository $orderRepository
    ) {
        $this->orderRepository = $orderRepository;
    }

    public function getOrders()
    {
        $dateStart = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 00:00:00', strtotime('-10 days')));
        $dateStop = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d 23:59:59'));

        $orders = $this->orderRepository->getByPeriod($dateStart, $dateStop);

        return Response::json($orders);
    }
}
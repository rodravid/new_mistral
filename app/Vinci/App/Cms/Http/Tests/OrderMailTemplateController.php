<?php

namespace Vinci\App\Cms\Http\Tests;

use Doctrine\ORM\EntityManagerInterface;
use View;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Website\Http\Order\Presenter\OrderPresenter;
use Vinci\Domain\Order\OrderRepository;

class OrderMailTemplateController extends Controller
{

    private $orderRepository;

    public function __construct(EntityManagerInterface $em, OrderRepository $orderRepository)
    {
        parent::__construct($em);

        $this->orderRepository = $orderRepository;
    }

    public function render($namespace, $template, $order)
    {
        $order = $this->orderRepository->getOneByNumber($order);

        $order = $this->presenter->model($order, OrderPresenter::class);

        return View::make('website::layouts.emails.order.' . $namespace . '.' . $template, compact('order'));
    }

}
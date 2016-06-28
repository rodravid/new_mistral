<?php

namespace Vinci\App\Cms\Http\Order;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Response;
use View;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Cms\Http\Order\Presenters\OrderPresenter;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Website\Http\Order\Presenter\OrderPresenter as OrderPresenterWeb;
use Vinci\Domain\Order\Commands\ChangeOrderStatusCommand;
use Vinci\Domain\Order\OrderRepository;
use Vinci\Domain\Order\OrderService;
use Vinci\Domain\Order\OrderStatus;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatusRepository;
use Vinci\Domain\Payment\PaymentStatus;

class OrderController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $trackingStatusRepository;

    protected $datatable = 'Vinci\Infrastructure\Orders\Datatables\OrderCmsDatatable';

    public function __construct(
        EntityManagerInterface $em,
        OrderService $service,
        OrderRepository $repository,
        OrderTrackingStatusRepository $trackingStatusRepository
    ) {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->trackingStatusRepository = $trackingStatusRepository;
    }

    public function index()
    {
        return $this->view('orders.list');
    }

    public function show($id)
    {
        $order = $this->repository->getOneById($id);

        $order = $this->presenter->model($order, OrderPresenter::class);

        return $this->view('orders.show')->withOrder($order);
    }

    public function edit($id)
    {
        $order = $this->repository->getOneById($id);

        $order = $this->presenter->model($order, OrderPresenter::class);

        $orderStatus = $this->getOrderStatus();

        $paymentStatus = $this->getPaymentStatus();

        $trackingStatus = $this->getTrackingStatus();

        return $this->view('orders.edit', compact('order', 'orderStatus', 'paymentStatus', 'trackingStatus'));
    }

    public function changeStatus($id, Request $request)
    {
        try {

            $order = $this->repository->getOneById($id);

            $command = new ChangeOrderStatusCommand(
                $order,
                $request->get('order_status'),
                $request->get('payment_status'),
                $request->get('order_tracking_status'),
                $request->has('send_mail'),
                $request->get('mail_subject'),
                $request->get('mail_body')
            );

            $this->service->changeOrderStatus($command);

            Flash::success(sprintf('Status do pedido #%s alterado com sucesso.', $order->getNumber()));

            return Redirect::route('cms.orders.edit', $order->getId());

        } catch (Exception $e) {


            throw $e;

            Flash::error('Não foi possível alterar o status do pedido.');

            return Redirect::back()->withInput();
        }

    }

    public function loadMailTemplate(Request $request)
    {
        $orderTrackingStatus = $this->trackingStatusRepository->getOneById($request->get('trackingStatusId'));
        $order = $this->presenter->model($this->repository->getOneById($request->get('orderId')), OrderPresenterWeb::class);
        $template = $orderTrackingStatus->getMailTemplate();

        $subject = str_replace('@NUMBER', $order->getNumber(), $template->getSubject());
        $body = View::make($template->getName(), compact('order'))->render();

        return Response::json(compact('subject', 'body'));
    }

    protected function getOrderStatus()
    {
        return OrderStatus::valuesLabed();
    }

    protected function getPaymentStatus()
    {
        return PaymentStatus::valuesLabed();
    }

    public function getTrackingStatus()
    {
        return html_select_array($this->trackingStatusRepository->getAll());
    }

}
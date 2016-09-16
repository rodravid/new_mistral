<?php

namespace Vinci\App\Cms\Http\Order;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;
use Response;
use View;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Cms\Http\Order\Presenters\OrderPresenter;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Integration\ERP\Logger\IntegrationLogger;
use Vinci\App\Integration\ERP\Order\OrderExporter;
use Vinci\App\Website\Http\Order\Presenter\OrderPresenter as OrderPresenterWeb;
use Vinci\Domain\Order\Commands\ChangeOrderStatusCommand;
use Vinci\Domain\Order\OrderRepository;
use Vinci\Domain\Order\OrderService;
use Vinci\Domain\Order\OrderStatus;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatus;
use Vinci\Domain\Order\TrackingStatus\OrderTrackingStatusRepository;
use Vinci\Domain\Payment\PaymentStatus;
use Vinci\Infrastructure\Exceptions\MailingException;

class OrderController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $trackingStatusRepository;

    protected $datatable = 'Vinci\Infrastructure\Orders\Datatables\OrderCmsDatatable';

    protected $orderExporter;

    public function __construct(
        EntityManagerInterface $em,
        OrderService $service,
        OrderRepository $repository,
        OrderTrackingStatusRepository $trackingStatusRepository,
        OrderExporter $orderExporter
    ) {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->trackingStatusRepository = $trackingStatusRepository;
        $this->orderExporter = $orderExporter;
    }

    public function index(Request $request)
    {
        $filters = $this->buildFiltersFrom($request);

        $orders = $this->repository->getAllFilteredBy($filters);
        $orders = $this->presenter->paginator($orders, OrderPresenter::class);

        $orders->setPath('/cms/orders');
        $filters['startDate'] = Carbon::createFromFormat('Y-m-d H:i:s', $filters['startDate'])
                                    ->format('d/m/Y 00:00:00');
        $filters['endAt'] = Carbon::createFromFormat('Y-m-d H:i:s', $filters['endAt'])
                                    ->format('d/m/Y 23:59:59');
        $orders->appends($filters);

        $orderStatuses = $this->trackingStatusRepository->getAll();
        $orderStatuses = Collection::make($orderStatuses)->pluck('title', 'id');

        return $this->view('orders.list', compact('orders', 'orderStatuses', 'filters'));
    }

    public function excel(Request $request)
    {
        $filters = $this->buildFiltersFrom($request);

        $orders = $this->repository->getAllFilteredBy($filters);
        $orders = $this->presenter->collection($orders, OrderPresenter::class);

        $fileName = 'Relatorio de Pedidos - '. Carbon::now()->format('Y/m/d H:i:s');

        Excel::create($fileName, function($excel) use ($orders) {

            $excel->sheet('Pedidos', function ($sheet) use ($orders) {
                $sheet->loadView('reports.orders.excel', compact('orders'));
            });

        })->download('xls');
    }

    private function buildFiltersFrom(Request $request)
    {
        $data = $request->all();

        $filters['startDate'] = isset($data['startDate'])
            ? Carbon::createFromFormat('d/m/Y H:i:s', $data['startDate'])
            : Carbon::now()
                ->subMonth()
                ->format('Y-m-d 00:00:00');

        $filters['endAt'] = isset($data['endAt'])
            ? Carbon::createFromFormat('d/m/Y H:i:s', $data['endAt'])
            : Carbon::now()
                ->format('Y-m-d 23:59:59');

        $filters['itemsPerPage'] = isset($data['itemsPerPage']) ? $data['itemsPerPage'] : 10;
        $filters['orderStatus'] = isset($data['orderStatus']) ? $data['orderStatus'] : $this->trackingStatusRepository->getAll()[0]->id;
        $filters['keyword'] = isset($data['keyword']) ? $data['keyword'] : '';

        return $filters;
    }

    public function show($id)
    {
        $order = $this->repository->getOneById($id);

        $order = $this->presenter->model($order, OrderPresenter::class);

        $integrationLogs = IntegrationLogger::type('order')->getByResourceId($id);
        $integrationLogsItems = IntegrationLogger::type('order_item')->getByResourceOwnerId($id);
        $integrationLogsAddress = IntegrationLogger::type('address')->getByResourceOwnerId($id);

        return $this->view('orders.show', compact('order', 'integrationLogs', 'integrationLogsItems', 'integrationLogsAddress'));
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

        } catch (MailingException $e) {

            Flash::error(sprintf('ATENÇÃO! O Status do pedido foi alterado com sucesso, entretanto não foi possível enviar o e-mail ao cliente. Tente novamente mais tarde.'));

            return Redirect::back()->withInput();

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

        $body = str_replace("<head","{w11HD}",$body);
        $body = str_replace("</head","{/w11HD}",$body);
        $body = str_replace("<meta","{w11MTA}",$body);
        $body = str_replace("<body","{w11BD}",$body);
        $body = str_replace("<style","{w11ST}",$body);
        $body = str_replace("</style","{/w11ST}",$body);

        $body = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $body);

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
        return html_select_array($this->trackingStatusRepository->getAll(), 'id', 'description');
    }

    public function exportToErpQueued($orderId, Request $request)
    {
        $order = $this->repository->find($orderId);

        try {

            $this->orderExporter->exportQueued($order, true);

            Flash::success("Pedido #{$order->getNumber()} enviado com sucesso para fila de integração!");

            return Redirect::route('cms.orders.show', $order->getId());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }

    }

}
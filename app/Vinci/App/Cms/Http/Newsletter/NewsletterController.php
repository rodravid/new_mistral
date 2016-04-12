<?php

namespace Vinci\App\Cms\Http\Newsletter;

use Doctrine\ORM\EntityManagerInterface;
use Excel;
use Illuminate\Http\Request;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\Domain\Newsletter\NewsletterRepository;

class NewsletterController extends Controller
{

    use DatatablesResponse;

    protected $repository;

    protected $datatable = 'Vinci\Infrastructure\Newsletter\Datatables\NewsletterCmsDatatable';

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        NewsletterRepository $repository
    )
    {
        parent::__construct($em);

        $this->repository = $repository;
    }

    public function index()
    {
        return $this->view('newsletter.list');
    }

    public function export(Request $request)
    {
        Excel::create('novo_tempo_pedidos_' . Carbon::now()->format('d-m-Y'), function($excel) use ($report, $startDate, $endDate) {

            $excel->sheet('Lista de Pedidos', function($sheet) use ($report, $startDate, $endDate) {
                $sheet->loadView('cms.relatorios.pedidos.excel', compact('report', 'startDate', 'endDate'));
            });

        })->export('xls');
    }

}
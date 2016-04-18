<?php

namespace Vinci\App\Cms\Http\Newsletter;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Excel;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Cms\Http\Newsletter\Presenters\NewsletterPresenter;
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

    public function export()
    {
        $newsletter = $this->repository->getAll();

        $newsletter = $this->presenter->collection($newsletter, NewsletterPresenter::class);

        Excel::create('Vinci_Newsletter_' . Carbon::now()->format('d-m-Y'), function($excel) use ($newsletter) {

            $excel->sheet('Newsletter', function($sheet) use ($newsletter) {
                $sheet->loadView('cms::newsletter.excel', ['result' => $newsletter]);
            });

        })->export('xls');
    }

}
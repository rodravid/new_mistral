<?php

namespace Vinci\App\Cms\Http\Dollar;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Excel;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Cms\Http\Dollar\Presenters\DollarPresenter;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\Domain\Dollar\DollarRepository;

class DollarController extends Controller
{

    use DatatablesResponse;

    protected $repository;

    protected $datatable = 'Vinci\Infrastructure\Dollar\Datatables\DollarCmsDatatable';

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        DollarRepository $repository
    )
    {
        parent::__construct($em);

        $this->repository = $repository;
    }

    public function index()
    {
        return $this->view('dollar.list');
    }

}
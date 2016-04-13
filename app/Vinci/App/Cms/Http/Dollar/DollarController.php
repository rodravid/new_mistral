<?php

namespace Vinci\App\Cms\Http\Dollar;

use Doctrine\ORM\EntityManagerInterface;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Dollar\DollarRepository;
use Vinci\Domain\Dollar\DollarService;

class DollarController extends Controller
{

    use DatatablesResponse;

    protected $repository;

    protected $datatable = 'Vinci\Infrastructure\Dollar\Datatables\DollarCmsDatatable';

    protected $aclService;

    protected $service;

    public function __construct(
        EntityManagerInterface $em,
        DollarRepository $repository,
        DollarService $service
    )
    {
        parent::__construct($em);

        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        return $this->view('dollar.list');
    }

    public function create()
    {
        return $this->view('dollar.create');
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['user'] = cmsUser();

            $this->service->create($data);

            Flash::success("Nova cotação do dólar criada com sucesso!");

            return Redirect::route('cms.dollar.list');

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }
    }

}
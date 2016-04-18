<?php

namespace Vinci\App\Cms\Http\Deadline;

use Doctrine\ORM\EntityManagerInterface;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Deadline\DeadlineRepository;
use Vinci\Domain\Deadline\DeadlineService;

class DeadlineController extends Controller
{

    use DatatablesResponse;

    protected $repository;

    protected $datatable = 'Vinci\Infrastructure\Deadline\Datatables\DeadlineCmsDatatable';

    protected $aclService;

    protected $service;

    public function __construct(
        EntityManagerInterface $em,
        DeadlineRepository $repository,
        DeadlineService $service
    )
    {
        parent::__construct($em);

        $this->repository = $repository;
        $this->service = $service;
    }

    public function index()
    {
        return $this->view('deadline.list');
    }

    public function create()
    {
        return $this->view('deadline.create');
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['user'] = cmsUser();

            $this->service->create($data);

            Flash::success("Novo prazo de entrega definido com sucesso!");

            return Redirect::route('cms.deadline.list');

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }
    }

}
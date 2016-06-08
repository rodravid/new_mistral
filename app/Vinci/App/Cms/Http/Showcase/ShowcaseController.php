<?php

namespace Vinci\App\Cms\Http\Showcase;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Showcase\ShowcaseRepository;
use Vinci\Domain\Showcase\ShowcaseService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Infrastructure\Showcase\Datatables\ShowcaseCmsDatatable;

class ShowcaseController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = ShowcaseCmsDatatable::class;

    protected $imageRepository;

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        ShowcaseService $service,
        ShowcaseRepository $repository,
        ImageRepository $imageRepository,
        ACLService $aclService
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->imageRepository = $imageRepository;
        $this->aclService = $aclService;
    }

    public function index()
    {
        return $this->view('showcases.list');
    }

    public function create()
    {
        return $this->view('showcases.create');
    }

    public function edit($id)
    {
        $showcase = $this->repository->findOrFail($id);

        return $this->view('showcases.edit')
            ->withShowcase($showcase);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $showcase = $this->service->create(array_merge($data, ['user' => $this->user]));

            Flash::success("Vitrine {$showcase->getTitle()} criada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $showcase->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $data = $request->all();

            $showcase = $this->service->update($data, $id);

            Flash::success("Vitrine {$showcase->getTitle()} atualizada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $showcase->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $showcase = $this->repository->find($id);

        try {

            $this->repository->delete($showcase);

            Flash::success("Vitrine {$showcase->getTitle()} excluída com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

}
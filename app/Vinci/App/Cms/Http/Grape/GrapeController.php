<?php

namespace Vinci\App\Cms\Http\Grape;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Grape\GrapeRepository;
use Vinci\Domain\Grape\GrapeService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Infrastructure\Grape\Datatables\GrapeCmsDatatable;

class GrapeController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = GrapeCmsDatatable::class;

    protected $imageRepository;

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        GrapeService $service,
        GrapeRepository $repository,
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
        return $this->view('grapes.list');
    }

    public function create()
    {
        return $this->view('grapes.create');
    }

    public function edit($id)
    {
        $grape = $this->repository->findOrFail($id);

        return $this->view('grapes.edit')
            ->withGrape($grape);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['picture'] = $request->file('picture');
            $data['picture_mobile'] = $request->file('picture_mobile');
            $data['user'] = cmsUser();

            $grape = $this->service->create($data);

            Flash::success("Uva {$grape->getName()} criada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $grape->getId());

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
            $data['picture'] = $request->file('picture');
            $data['picture_mobile'] = $request->file('picture_mobile');
            $data['user'] = cmsUser();

            $grape = $this->service->update($data, $id);

            Flash::success("Uva {$grape->getName()} atualizada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $grape->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $grape = $this->repository->find($id);

        try {

            $this->repository->delete($grape);

            Flash::success("Uva {$grape->getName()} excluída com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function removeImage($grapeId, $imageId)
    {
        try {

            $grape = $this->repository->find($grapeId);
            $image = $this->imageRepository->find($imageId);

            $this->service->removeImage($image, $grape);

            Flash::success("Imagem excluída com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$grapeId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

}
<?php

namespace Vinci\App\Cms\Http\Highlight;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Highlight\HighlightRepository;
use Vinci\Domain\Highlight\HighlightService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Infrastructure\Highlight\Datatables\HighlightCmsDatatable;

class HighlightController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = HighlightCmsDatatable::class;

    protected $imageRepository;

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        HighlightService $service,
        HighlightRepository $repository,
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
        return $this->view('highlights.list');
    }

    public function create()
    {
        return $this->view('highlights.create');
    }

    public function edit($id)
    {
        $highlight = $this->repository->findOrFail($id);

        return $this->view('highlights.edit')
            ->withHighlight($highlight);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['image_desktop'] = $request->file('image_desktop');
            $data['image_mobile'] = $request->file('image_mobile');
            $data['user'] = cmsUser();

            $highlight = $this->service->create($data);

            Flash::success("Destaque {$highlight->getTitle()} criado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $highlight->getId());

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
            $data['image_desktop'] = $request->file('image_desktop');
            $data['image_mobile'] = $request->file('image_mobile');
            $data['user'] = cmsUser();

            $highlight = $this->service->update($data, $id);

            Flash::success("Destaque {$highlight->getTitle()} atualizado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $highlight->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $highlight = $this->repository->find($id);

        try {

            $this->repository->delete($highlight);

            Flash::success("Destaque {$highlight->getTitle()} excluído com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function removeImage($highlightId, $imageId)
    {
        try {

            $highlight = $this->repository->find($highlightId);
            $image = $this->imageRepository->find($imageId);

            $this->service->removeImage($image, $highlight);

            Flash::success("Imagem excluída com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$highlightId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

}
<?php

namespace Vinci\App\Cms\Http\Showcase;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Response;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Showcase\ShowcaseRepository;
use Vinci\Domain\Showcase\ShowcaseService;
use Vinci\Infrastructure\Showcase\Datatables\ShowcaseCmsDatatable;
use Vinci\Infrastructure\Showcase\Datatables\ShowcaseProductsCmsDatatable;

class ShowcaseController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    private $imageRepository;

    protected $aclService;

    protected $datatable = ShowcaseCmsDatatable::class;

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
        $this->aclService = $aclService;
        $this->imageRepository = $imageRepository;
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

    public function itemsDatatable(Request $request)
    {
        return $this->getDatatable(ShowcaseProductsCmsDatatable::class, $request);
    }

    public function addItem(Request $request)
    {
        try {

            $this->service->addItemWithProductId($request->get('showcaseId'), $request->get('productId'));

            return Response::json(['message' => 'Produto adicionado com sucesso!']);

        } catch (Exception $e) {

            return Response::json(['message' => 'Não foi possível adicionar o produto. Tente novamente.']);
        }
    }

    public function removeItem($showcase, $item)
    {
        try {

            $this->service->removeItem($showcase, $item);

            return Response::json(['message' => 'Item removido com sucesso.']);

        } catch (Exception $e) {

            return Response::json(['message' => 'Não foi possível remover o item.'], 400);

        }
    }

    public function updateItemPosition($showcase, $item, Request $request)
    {

        try {

            $this->service->updateItemPosition($showcase, $item, $request->get('position'));

            return Response::json(['message' => 'Order atualizada com sucesso.']);

        } catch (Exception $e) {

            return Response::json(['message' => 'Não foi possível atualizar a ordem  do item.'], 400);

        }

    }

    public function removeImage($showcaseId, $imageId)
    {
        try {

            $showcase = $this->repository->find($showcaseId);
            $image = $this->imageRepository->find($imageId);

            $this->service->removeImage($image, $showcase);

            Flash::success("Imagem excluída com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$showcaseId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

}
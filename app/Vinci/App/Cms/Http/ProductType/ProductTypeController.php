<?php

namespace Vinci\App\Cms\Http\ProductType;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\ACL\ACLService;
use Vinci\Domain\ProductType\ProductTypeRepository;
use Vinci\Domain\ProductType\ProductTypeService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Infrastructure\ProductType\Datatables\ProductTypeCmsDatatable;

class ProductTypeController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = ProductTypeCmsDatatable::class;

    protected $imageRepository;

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        ProductTypeService $service,
        ProductTypeRepository $repository,
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
        return $this->view('product_type.list');
    }

    public function create()
    {
        return $this->view('product_type.create');
    }

    public function edit($id)
    {
        $productType = $this->repository->findOrFail($id);

        return $this->view('product_type.edit')
            ->with('productType', $productType);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['picture'] = $request->file('picture');
            $data['picture_mobile'] = $request->file('picture_mobile');
            $data['user'] = cmsUser();

            $productType = $this->service->create($data);

            Flash::success("Tipo de produto {$productType->getName()} criado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $productType->getId());

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

            $productType = $this->service->update($data, $id);

            Flash::success("Tipo de produto {$productType->getName()} atualizado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $productType->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $productType = $this->repository->find($id);

        try {

            $this->repository->delete($productType);

            Flash::success("Tipo de produto {$productType->getName()} excluído com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function removeImage($productTypeId, $imageId)
    {
        try {

            $productType = $this->repository->find($productTypeId);
            $image = $this->imageRepository->find($imageId);

            $this->service->removeImage($image, $productType);

            Flash::success("Imagem excluída com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$productTypeId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

}
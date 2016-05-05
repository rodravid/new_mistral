<?php

namespace Vinci\App\Cms\Http\Product;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Product\ProductService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Services\ProductManagementService;
use Vinci\Infrastructure\Product\Datatables\ProductCmsDatatable;

class ProductController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = ProductCmsDatatable::class;

    protected $imageRepository;

    public function __construct(
        EntityManagerInterface $em,
        ProductManagementService $service,
        ProductRepository $repository,
        ImageRepository $imageRepository
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->imageRepository = $imageRepository;
    }

    public function index()
    {
        return $this->view('products.list');
    }

    public function create(Request $request)
    {
        $type = $request->get('type');

        return $this->view('products.create', compact('type'));
    }

    public function edit($id)
    {
        $product = $this->repository->findOrFail($id);

        return $this->view('products.edit')
            ->withProduct($product);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['image_desktop'] = $request->file('image_desktop');
            $data['image_mobile'] = $request->file('image_mobile');

            $product = $this->service->create($data);

            Flash::success("Destaque {$product->getTitle()} criado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $product->getId());

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

            dd($data);

            $data['image_desktop'] = $request->file('image_desktop');
            $data['image_mobile'] = $request->file('image_mobile');

            $product = $this->service->update($data, $id);

            Flash::success("Destaque {$product->getTitle()} atualizado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $product->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $product = $this->repository->find($id);

        try {

            $this->repository->delete($product);

            Flash::success("Destaque {$product->getTitle()} excluído com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function removeImage($productId, $imageId)
    {
        try {

            $product = $this->repository->find($productId);
            $image = $this->imageRepository->find($imageId);

            $this->service->removeImage($image, $product);

            Flash::success("Imagem excluída com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$productId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

}
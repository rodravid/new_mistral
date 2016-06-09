<?php

namespace Vinci\App\Cms\Http\Product;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Response;
use Vinci\App\Cms\Http\Controller;
use Vinci\App\Core\Services\Datatables\DatatablesResponse;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\Domain\Channel\ChannelRepository;
use Vinci\Domain\Product\Product;
use Vinci\Domain\Product\ProductService;
use Vinci\Domain\Image\ImageRepository;
use Vinci\Domain\Product\ProductType;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Product\Services\ProductImageService;
use Vinci\Domain\Product\Services\ProductManagementService;
use Vinci\Infrastructure\Product\Datatables\ProductCmsDatatable;

class ProductController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = ProductCmsDatatable::class;

    protected $imageRepository;

    protected $channelRepository;

    protected $imageService;

    public function __construct(
        EntityManagerInterface $em,
        ProductManagementService $service,
        ProductRepository $repository,
        ImageRepository $imageRepository,
        ProductImageService $imageService,
        ChannelRepository $channelRepository
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->imageRepository = $imageRepository;
        $this->channelRepository = $channelRepository;
        $this->imageService = $imageService;
    }

    public function index()
    {
        return $this->view('products.list');
    }

    public function create(Request $request)
    {
        $type = $this->normalizeType($request);
        $wineGrapes = $this->getGrapes($request);
        $wineScores = $this->getScores($request);
        $channel = $this->channelRepository->getDefaultChannel();

        return $this->view('products.create', compact('type', 'wineGrapes', 'wineScores', 'channel'));
    }

    public function edit(Request $request, $id)
    {
        $product = $this->repository->findOrFail($id);

        $type = $product->getArchType();

        $channel = $product->getDefaultChannel();

        $view = $this->view('products.edit', compact('product', 'type', 'channel'));

        if ($type->is('wine')) {
            $view->with('wineGrapes', $this->getGrapes($request, $product));
            $view->with('wineScores', $this->getScores($request, $product));
        }

        return $view;
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $data['image_desktop'] = $request->file('image_desktop');
            $data['image_mobile'] = $request->file('image_mobile');

            $product = $this->service->create($data);

            Flash::success("Produto {$product->getTitle()} criado com sucesso!");

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

            $product = $this->service->update($data, $id);

            Flash::success("Produto {$product->getTitle()} atualizado com sucesso!");

            return Redirect::route($this->getEditRouteName(), $product->getId())
                ->withInput(['current-tab' => $request->get('current-tab')]);

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

            Flash::success("Produto {$product->getTitle()} excluído com sucesso!");

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

            $this->imageService->removeFrom($product, $image);

            Flash::success("Imagem excluída com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$productId]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    protected function normalizeType(Request $request)
    {
        $type = $request->get('type', 'product');
        return $this->entityManager->getRepository(ProductType::class)->findOneBy(['code' => $type]);
    }

    protected function getGrapes(Request $request, Product $product = null)
    {
        if ($request->old('grapes')) {

            $grapes = [];

            foreach ($request->old('grapes') as $grape) {
                $grapes[] = $grape;
            }

            return $grapes;
        }

        if ($product) {
            
            $grapes = [];

            foreach ($product->getGrapes() as $grapeContent) {

                $grapes[] = [
                    'id' => $grapeContent->getGrape()->getId(),
                    'weight' => $grapeContent->getWeight(),
                    'name' => $grapeContent->getGrape()->getName()
                ];
            }

            return $grapes;
        }
    }

    protected function getScores(Request $request, Product $product = null)
    {
        if ($request->old('scores')) {

            $scores = [];

            foreach ($request->old('scores') as $score) {
                $scores[] = $score;
            }

            return $scores;
        }

        if ($product) {
            return $product->getScores();
        }
    }

    public function getProductsSelect(Request $request)
    {
        $keyword = $request->get('term');

        $qb = $this->repository->createQueryBuilder('p');

        $qb->select('p.id as id', 'CONCAT( CONCAT(v.sku, \' - \'),  v.title) as text')
            ->join('p.variants', 'v');

        $qb->where($qb->expr()->eq('v.sku', ':id'));

        $qb->orWhere($qb->expr()->orX(
            $qb->expr()->like('v.title', ':search')
        ));

        $qb->setParameter('id', $keyword);
        $qb->setParameter('search', '%' . $keyword . '%');

        $results = $qb->getQuery()->getArrayResult();

        return Response::json(['results' => $results]);
    }

}
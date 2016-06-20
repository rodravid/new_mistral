<?php

namespace Vinci\App\Cms\Http\Promotion\DiscountPromotion;

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
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionRepository;
use Vinci\Domain\Promotion\Types\Discount\DiscountPromotionService;
use Vinci\Infrastructure\Promotion\Types\Discount\Datatables\DiscountPromotionCmsDatatable;
use Vinci\Infrastructure\Promotion\Datatables\PromotionProductsCmsDatatable;

class DiscountPromotionController extends Controller
{

    use DatatablesResponse;

    protected $service;

    protected $repository;

    protected $datatable = DiscountPromotionCmsDatatable::class;

    protected $aclService;

    public function __construct(
        EntityManagerInterface $em,
        DiscountPromotionService $service,
        DiscountPromotionRepository $repository,
        ACLService $aclService
    )
    {
        parent::__construct($em);

        $this->service = $service;
        $this->repository = $repository;
        $this->aclService = $aclService;
    }

    public function index()
    {
        return $this->view('promotions.discount.list');
    }

    public function create()
    {
        return $this->view('promotions.discount.create');
    }

    public function edit($id)
    {
        $promotion = $this->repository->findOrFail($id);

        return $this->view('promotions.discount.edit')
            ->withPromotion($promotion);
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();

            $promotion = $this->service->create(array_merge($data, ['user' => $this->user]));

            Flash::success("Promoção {$promotion->getTitle()} criada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $promotion->getId());

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

            $promotion = $this->service->update($data, $id);

            Flash::success("Promoção {$promotion->getTitle()} atualizada com sucesso!");

            return Redirect::route($this->getEditRouteName(), $promotion->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (Exception $e) {

            Flash::error($e->getMessage());

            return Redirect::back()->withInput();
        }

    }

    public function destroy($id)
    {
        $promotion = $this->repository->find($id);

        try {

            $this->repository->delete($promotion);

            Flash::success("Promoção {$promotion->getTitle()} excluída com sucesso!");

            return Redirect::route($this->getListRouteName());

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
    }

    public function itemsDatatable(Request $request)
    {
        return $this->getDatatable(PromotionProductsCmsDatatable::class, $request);
    }

    public function addItem(Request $request)
    {
        try {

            $this->service->addItem($request->get('promotionId'), $request->get('productId'));

            return Response::json(['message' => 'Produto adicionado com sucesso!']);

        } catch (Exception $e) {

            return Response::json(['message' => 'Não foi possível adicionar o produto. Tente novamente.']);
        }
    }

    public function removeItem($promotion, $item)
    {
        try {

            $this->service->removeItem($promotion, $item);

            return Response::json(['message' => 'Produto removido com sucesso.']);

        } catch (Exception $e) {

            return Response::json(['message' => 'Não foi possível remover o produto.'], 400);

        }
    }

    public function updateItemPosition($promotion, $item, Request $request)
    {

        try {

            $this->service->updateItemPosition($promotion, $item, $request->get('position'));

            return Response::json(['message' => 'Order atualizada com sucesso.']);

        } catch (Exception $e) {

            return Response::json(['message' => 'Não foi possível atualizar a ordem  do item.'], 400);

        }

    }

}
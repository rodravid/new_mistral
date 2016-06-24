<?php

namespace Vinci\App\Cms\Http\Promotion;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Response;
use Vinci\App\Cms\Http\Controller;
use Vinci\Domain\Promotion\PromotionRepository;
use Vinci\Domain\Promotion\PromotionService;

class PromotionController extends Controller
{

    protected $promotionService;

    protected $promotionRepository;

    public function __construct(
        EntityManagerInterface $em,
        PromotionService $promotionService,
        PromotionRepository $promotionRepository
    ) {
        parent::__construct($em);

        $this->promotionService = $promotionService;
        $this->promotionRepository = $promotionRepository;
    }

    public function addProductsFromFilters($promotionId, Request $request)
    {
        try {

            $this->promotionService->addProductsFromFilters($promotionId, $request->all());

            return $this->buildSuccessResponse();

        } catch (Exception $e) {

            return $this->buildFailedResponse();
        }
    }

    public function addProducts($promotionId, Request $request)
    {
        try {

            $this->promotionService->addProducts($promotionId, $request->get('products'));

            return $this->buildSuccessResponse();

        } catch (Exception $e) {

            return $this->buildFailedResponse();
        }
    }

    public function addAllProducts($promotionId)
    {
        try {

            $this->promotionService->addAllProducts($promotionId);

            return $this->buildSuccessResponse();

        } catch (Exception $e) {

            return $this->buildFailedResponse();
        }
    }

    public function addProductsFromFile($promotionId, Request $request)
    {
        try {

            $this->promotionService->attachProductsFromExcel($promotionId, $request->file('file'));

            return $this->buildSuccessResponse();

        } catch (Exception $e) {

            return $this->buildFailedResponse();
        }
    }

    public function buildSuccessResponse()
    {
        return Response::json(['error' => false, 'message' => 'Produtos adicionados com sucesso!']);
    }

    public function buildFailedResponse()
    {
        return Response::json(['error' => true, 'Não foi possível adicionar os produtos.']);
    }

    public function removeSeal($promotion)
    {
        try {

            $promotion = $this->promotionRepository->getOneById($promotion);

            $promotion->removeSealImage();

            $this->promotionRepository->save($promotion);

            Flash::success("Selo excluído com sucesso!");

            return Redirect::route($this->getEditRouteName(), [$promotion->getId()]);

        } catch (Exception $e) {

            Flash::error($e->getMessage());
            return Redirect::back();
        }
        
    }

}
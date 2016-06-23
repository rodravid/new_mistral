<?php

namespace Vinci\App\Cms\Http\Promotion;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Illuminate\Http\Request;
use Response;
use Vinci\App\Cms\Http\Controller;
use Vinci\Domain\Promotion\PromotionService;

class PromotionController extends Controller
{

    protected $promotionService;

    public function __construct(EntityManagerInterface $em, PromotionService $promotionService)
    {
        parent::__construct($em);

        $this->promotionService = $promotionService;
    }

    public function addProductsFromFilters($promotionId, Request $request)
    {
        try {

            $this->promotionService->addProductsFromFilters($promotionId, $request->all());

            return Response::json(['error' => false, 'message' => 'Produtos adicionados com sucesso!']);

        } catch (Exception $e) {

            return Response::json(['error' => true, 'Não']);
        }
    }

    public function addProducts($promotionId, Request $request)
    {
        try {

            $this->promotionService->addProducts($promotionId, $request->get('products'));

            return Response::json(['error' => false, 'message' => 'Produtos adicionados com sucesso!']);

        } catch (Exception $e) {

            return Response::json(['error' => true, 'Não']);
        }
    }

    public function addAllProducts($promotionId, Request $request)
    {

    }

    public function addProductsFromFile($promotionId, Request $request)
    {

    }

}
<?php

namespace Vinci\App\Website\Http\Shipping;

use Exception;
use Illuminate\Http\Request;
use Response;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Address\PostalCode;
use Vinci\Domain\Product\ProductShippable;
use Vinci\Domain\Product\Repositories\ProductRepository;
use Vinci\Domain\Shipping\Services\ShippingService;

class ShippingController extends Controller
{
    protected $shippingService;

    protected $productRepository;

    public function __construct(ShippingService $shippingService, ProductRepository $productRepository)
    {
        $this->shippingService = $shippingService;
        $this->productRepository = $productRepository;
    }

    public function getShippingPriceAndDeadlines(Request $request)
    {
        try {
            $data = $request->all();

            $product = $this->productRepository->find($data['product']);

            $shippable = new ProductShippable($product, $data['itemQuantity'], $data['boxQuantity']);

            $shippingOption = $this->shippingService->getShippingByLowestPrice(new PostalCode($data['cep']), $shippable);

            return Response::json([$shippingOption->present()->deadline]);
        } catch (Exception $e) {

            return Response::json(['message' => 'Não foi possível calcular o prazo de entrega'], 400);

        }
    }
}
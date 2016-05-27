<?php

namespace Vinci\App\Website\Http\Order;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Redirect;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Channel\Contracts\ChannelProvider;
use Vinci\Domain\Order\OrderService;
use Vinci\Domain\ShoppingCart\Provider\ShoppingCartProvider;

class OrderController extends Controller
{
    protected $service;

    protected $channelProvider;

    protected $cartProvider;

    public function __construct(
        EntityManagerInterface $em,
        OrderService $service,
        ChannelProvider $channelProvider,
        ShoppingCartProvider $cartProvider
    ) {
        parent::__construct($em);

        $this->service = $service;
        $this->channelProvider = $channelProvider;
        $this->cartProvider = $cartProvider;
    }

    public function store(Request $request)
    {
        try {

            $order = $this->service->create($this->getData($request));

            return Redirect::route('checkout.confirmation.index', $order->getId());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        }
//        catch (Exception $e) {
//
//            Flash::error($e->getMessage());
//
//            return Redirect::back()->withInput();
//        }

    }

    protected function getData(Request $request)
    {
        $data = $request->all();

        return array_merge($data, [
            'customer' => $this->user,
            'channel' => $this->channelProvider->getChannel(),
            'cart' => $this->cartProvider->getShoppingCart()
        ]);
    }

}
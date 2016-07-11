<?php

namespace Vinci\App\Website\Http\Order;

use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Flash;
use Illuminate\Http\Request;
use Log;
use Redirect;
use Session;
use Vinci\App\Core\Services\Validation\Exceptions\ValidationException;
use Vinci\App\Website\Http\Controller;
use Vinci\Domain\Channel\Contracts\ChannelProvider;
use Vinci\Domain\Order\OrderService;
use Vinci\Domain\ShoppingCart\Exceptions\InvalidShoppingCartException;
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

            return Redirect::route('checkout.confirmation.index', $order->getNumber());

        } catch (ValidationException $e) {

            return Redirect::back()->withErrors($e->getErrors())->withInput();

        } catch (InvalidShoppingCartException $e) {

            return Redirect::route('cart.index');

        } catch (Exception $e) {

            throw $e;

            Log::error(sprintf('Erro ao finalizar pedido: %s | Trace: %s', $e->getMessage(), $e->getTraceAsString()));

            Flash::error('Não foi possível finalizar seu pedido, por gentileza entrar em contato através do email ' . env('CONTACT_MAIL'));

            return Redirect::back()->withInput();

        } finally {
            Session::flash('scroll', true);
        }
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
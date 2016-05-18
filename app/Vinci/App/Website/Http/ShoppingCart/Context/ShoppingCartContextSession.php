<?php

namespace Vinci\App\Website\Http\ShoppingCart\Context;

use Illuminate\Session\SessionInterface;
use Vinci\Domain\ShoppingCart\Context\Contracts\CartInterface;
use Vinci\Domain\ShoppingCart\Context\Contracts\ShoppingCartContext;
use Vinci\Domain\ShoppingCart\ShoppingCartInterface;

class ShoppingCartContextSession implements ShoppingCartContext
{

    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getCurrentCartIdentifier()
    {
        return $this->session->get(self::STORAGE_KEY);
    }

    public function setCurrentCartIdentifier(ShoppingCartInterface $shoppingCart)
    {
        $this->session->set(self::STORAGE_KEY, $shoppingCart->getId());
    }

    public function resetCurrentCartIdentifier()
    {
        $this->session->remove(self::STORAGE_KEY);
    }
}
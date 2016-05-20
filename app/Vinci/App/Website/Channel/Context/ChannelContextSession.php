<?php

namespace Vinci\App\Website\Channel\Context;

use Illuminate\Session\SessionInterface;
use Vinci\Domain\Channel\Contracts\Channel;
use Vinci\Domain\Channel\Contracts\ChannelContext;

class ChannelContextSession implements ChannelContext
{

    protected $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getCurrentChannelIdentifier()
    {
        return $this->session->get(self::STORAGE_KEY);
    }

    public function setCurrentChannelIdentifier(Channel $channel)
    {
        $this->session->set(self::STORAGE_KEY, $channel->getCode());
    }

    public function resetCurrentChannelIdentifier()
    {
        $this->session->remove(self::STORAGE_KEY);
    }
}
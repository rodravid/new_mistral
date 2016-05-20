<?php

namespace Vinci\App\Website\Channel;

use Vinci\Domain\Channel\ChannelRepository;
use Vinci\Domain\Channel\Contracts\Channel;
use Vinci\Domain\Channel\Contracts\ChannelContext;
use Vinci\Domain\Channel\Contracts\ChannelProvider as ChannelProviderInterface;

class ChannelProvider implements ChannelProviderInterface
{

    protected $context;

    protected $currentChannel;

    protected $repository;

    public function __construct(ChannelContext $context, ChannelRepository $repository)
    {
        $this->context = $context;
        $this->repository = $repository;
    }

    public function getChannel()
    {
        if (! $this->currentChannel) {

            $channel = $this->provideChannel();

            $this->setChannel($channel);

            return $channel;
        }

        return $this->currentChannel;
    }

    public function provideChannel()
    {
        $channelIdentifier = $this->context->getCurrentChannelIdentifier();

        if ($channelIdentifier !== null) {

            $channel = $this->repository->findByCode($channelIdentifier);

            if ($channel !== null) {
                return $channel;
            }

        }

        return $this->repository->getDefaultChannel();
    }

    public function setChannel(Channel $channel)
    {
        $this->currentChannel = $channel;
        $this->context->setCurrentChannelIdentifier($channel);
    }

}
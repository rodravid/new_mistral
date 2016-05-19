<?php

namespace Vinci\App\Website\Channel;

use Vinci\Domain\Channel\Contracts\ChannelProvider as ChannelProviderInterface;

class ChannelProvider implements ChannelProviderInterface
{

    public function getChannel()
    {
        return 'outro';
    }
}
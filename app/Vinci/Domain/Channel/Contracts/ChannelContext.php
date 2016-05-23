<?php

namespace Vinci\Domain\Channel\Contracts;

interface ChannelContext
{

    const STORAGE_KEY = '_webeleven_channel_id';

    public function getCurrentChannelIdentifier();

    public function setCurrentChannelIdentifier(Channel $channel);

    public function resetCurrentChannelIdentifier();

}
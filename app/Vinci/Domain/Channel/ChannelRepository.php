<?php

namespace Vinci\Domain\Channel;

interface ChannelRepository
{

    public function findByCode($code);

    public function getDefaultChannel();

}
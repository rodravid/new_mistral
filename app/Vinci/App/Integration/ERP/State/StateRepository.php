<?php
namespace Vinci\App\Integration\ERP\State;

interface StateRepository
{

    public function syncStates($states, $detach = false);

    public function create(array $state);

    public function update(array $state);

}
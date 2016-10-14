<?php
namespace Vinci\App\Integration\ERP\State;

interface StateRepository
{

    public function syncState($states);

    public function syncStates($states, $detach = false);

    public function create($state);

    public function update($state);

}
<?php

namespace Vinci\Domain\Country;

interface CountryRepository
{

    public function find($id);

    public function getOneBySlug($slug);

    public function getAll();

    public function create(array $data);

}
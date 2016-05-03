<?php

namespace Vinci\App\Core\Services\Sanitizer\Contracts;

interface Sanitizer
{

    /**
     * Register a new sanitization method.
     *
     * @param  string $name
     * @param  mixed  $callback
     * @return void
     */
    public function register($name, $callback);

    /**
     * Sanitize a dataset using rules.
     *
     * @param  array $rules
     * @param  array $data
     * @return void
     */
    public function sanitize($rules, &$data);

}
<?php

namespace Vinci\App\Core\Http\Controllers;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $viewNamespace;

    protected $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    protected function view($view = null, $data = [], $mergeData = [])
    {
        if (! empty($this->viewNamespace) && ! str_contains($view, '::')) {
            $view = $this->viewNamespace . '::' . $view;
        }

        return view($view, $data, $mergeData);
    }
}

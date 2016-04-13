<?php

namespace Vinci\App\Core\Http\Controllers;

use App;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Vinci\App\Core\Services\Presenter\Presenter;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $viewNamespace;

    protected $entityManager;

    /**
     * @var Presenter
     */
    protected $presenter;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
        $this->presenter = App::make(Presenter::class);
    }

    protected function view($view = null, $data = [], $mergeData = [])
    {
        if (! empty($this->viewNamespace) && ! str_contains($view, '::')) {
            $view = $this->viewNamespace . '::' . $view;
        }

        return view($view, $data, $mergeData);
    }
}
